export default class NsiContactFormField extends React.Component {
  render() {
    const attr = {};
    this.props.attributes.map((attribute) => { attr[attribute.name] = attribute.content });

    switch (this.props.type) {
      case 'text':
      case 'email':
        return (<div className="field-group">
          <label htmlFor={this.props.uuid}>{this.props.name} {this.props.required ? (<sup>*</sup>) : ''}</label>
          <input type={this.props.type} value={this.props.value} onChange={(e) => { this.props.onChange(e, this.props.index) }} id={this.props.uuid} name={this.props.uuid} {...attr} required={this.props.required} />
        </div>)
      case 'file':
        return (<div className="field-group">
          <label htmlFor={this.props.uuid}>{this.props.name} {this.props.required ? (<sup>*</sup>) : ''}</label>
          <input type={this.props.type} onChange={(e) => { this.props.onChange(e, this.props.index) }} id={this.props.uuid} name={this.props.uuid} {...attr} required={this.props.required} />
        </div>)
      case 'textarea':
        return (<div className="field-group">
          <label htmlFor={this.props.uuid}>{this.props.name} {this.props.required ? (<sup>*</sup>) : ''}</label>
          <textarea id={this.props.uuid} value={this.props.value} name={this.props.uuid} onChange={(e) => { this.props.onChange(e, this.props.index) }} {...attr}></textarea>
        </div>)
      case 'select':
        return (<div className="field-group">
          <label htmlFor={this.props.uuid}>{this.props.name} {this.props.required ? (<sup>*</sup>) : ''}</label>
          <select id={this.props.uuid} name={this.props.uuid} value={this.props.value} onChange={(e) => { this.props.onChange(e, this.props.index) }} {...attr}>
            {this.props.choices.map((choice, index) => <option key={index}>{choice.name}</option>)}
          </select>
        </div>)
      case 'checkbox':
      case 'radio':
        return (<div className="field-group">
          <label htmlFor={this.props.uuid}>{this.props.name} {this.props.required ? (<sup>*</sup>) : ''}</label>
          {this.props.choices.map((choice, index) => <div className="input-group" key={index}>
            <input id={`${this.props.uuid}_${index}`} onChange={(e) => { this.props.onChange(e, this.props.index) }} type={this.props.type} name={this.props.uuid + '[]'} value={choice.name} checked={this.props.value[choice.name]} {...attr} />
            <label htmlFor={`${this.props.uuid}_${index}`}>{choice.name}</label></div>
          )}
        </div>)
      case 'button':
        return (<div className="field-group"><button type={attr.type ? attr.type : 'submit'} {...attr}>{this.props.name}</button></div>)
      case 'hidden':
        return null;
    }

  }
}