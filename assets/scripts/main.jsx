import NSIContactForm from './Components/NSIContactForm';

console.log(document.getElementsByClassName(nsi_contact_form.widget_class));
for (let item of document.getElementsByClassName(nsi_contact_form.widget_class)) {
  console.log(item);
  ReactDOM.render(
    <NSIContactForm {...item.dataset}></NSIContactForm>,
    item
  );
}