import NsiContactFormField from './NsiContactFormField';

class NSIContactForm extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      message: null,
      fields: [],
      progress: 1
    }
    this.getFields();
    this.progressChange = this.progressChange.bind(this);
  }

  getFields() {
    jQuery.ajax({
      url: nsi_contact_form.fields_rest_route + this.props.formid,
      method: 'get',
      xhrFields: {
        onprogress: this.progressChange
      },
      success: (datas) => {
        this.setState({
          fields: datas.fields.map((field) => {
            switch (field.type) {
              case 'checkbox':
              case 'radio':
                field.value = {};
                for (let choice in field.choices) {
                  field.value[field.choices[choice].name] = false;
                };
                break;
              case 'select':
                field.value = field.choices[0].name;
              default:
                field.values = null;
            }
            return field;
          }),
          message: null,
          progress: null
        })
      }
    })
  }

  onFieldChange(event, key) {
    const fields = [...this.state.fields];
    switch (fields[key].type) {
      case 'checkbox':
        fields[key].value[event.currentTarget.value] = event.currentTarget.checked;
        break;
      case 'radio':
        for (let val in fields[key].value) {
          fields[key].value[val] = false;
          if (event.currentTarget.value == val && event.currentTarget.checked) {
            fields[key].value[val] = true;
          }
        }
        break;
      case 'file':
        fields[key].value = event.currentTarget.files[0];
        break;
      default:
        fields[key].value = event.currentTarget.value;
    }
    console.log(fields);
    this.setState({ fields: fields });
  }

  onSubmit(event) {
    event.preventDefault();
    this.setState({ progress: 1 });

    if (nsi_contact_form.recaptcha_public && grecaptcha) {
      grecaptcha.execute(nsi_contact_form.recaptcha_public, { action: 'homepage' }).then((token) => {
        this.sendForm(token);
      });
    }
    else {
      this.sendForm();
    }

  }

  sendForm(token) {
    const data = new FormData();
    for (let field of this.state.fields) {
      switch (field.type) {
        case 'file':
          if (field.value) {
            data.append(field.uuid, field.value, field.value.name);
          }
          else {
            data.append(field.uuid, null);
          }
          break;
        default:
          data.append(field.uuid, field.value);
      }
    }
    if (token) {
      data.append('recaptcha_response', token);
    }
    console.log(data);

    jQuery.ajax({
      url: nsi_contact_form.ajax_url,
      method: 'post',
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      async: true,
      xhr: () => {
        var myXhr = jQuery.ajaxSettings.xhr();
        console.log(myXhr);
        if (myXhr.upload) {
          myXhr.upload.addEventListener('progress', this.progressChange, false);
        }
        return myXhr;
      },
      success: (datas) => {
        this.setState({ progress: null, fields: [], message: (<div className={`alert alert-${datas.data.type}`}><strong>{datas.data.title}</strong><br />{datas.data.message}</div>) })
      }
    })
  }

  progressChange(evt) {
    console.log(evt);
    if (evt.lengthComputable) {
      const newValue = (evt.loaded / evt.total * 100);
      this.setState({ progress: newValue });
    }
  }

  render() {
    const { message, fields, progress } = this.state;
    if (progress) {
      return (<progress value={progress} max="100"></progress>);
    }
    else {
      const ret = [];
      if (message) {
        ret.push(message);
      }
      ret.push(<form onSubmit={(e) => this.onSubmit(e)}>
        {fields.map((attr, index) => <NsiContactFormField key={index} onChange={(e, k) => { this.onFieldChange(e, k) }} index={index} {...attr}></NsiContactFormField>)}
      </form>);
      return ret;
    }
  }
}
export default NSIContactForm;