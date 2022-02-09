const showModal = async (modalKey, url, itemId) => {
  let modal = $(modalKey);
  let modalTitle = $(modalKey + " h5[data-label=modal-title]");
  let modalTableBody = $(modalKey + " table[data-label=modal-table] tbody");
  let modalFooter = $(modalKey + " [data-label=modal-footer]");
  let modalTableBodyHTML = "";
  let modalFooterHTML = "";
  let title = "";

  let repsonse = await sendRequest(url, { itemId }, "GET");
  let modalInfo = repsonse.data.modal;

  title = modalInfo.title;

  $.each(modalInfo.children, function (index, field) {
    let title = field.title;
    let value = field.value;
    let type = field.type;

    modalTableBodyHTML += `<tr><td>${title}</td><td>${value}</td></tr>`;
  });

  if (modalInfo.actions) {
    $.each(modalInfo.actions, function (index, action) {
      modalFooterHTML += `<a href="${action.href}" class="btn ${action.className}" target="_blank">${action.text}</a>`;
    });
  }

  modalFooterHTML += `
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  `;

  $(modalTitle).text(title);
  $(modalTableBody).html(modalTableBodyHTML);
  $(modalFooter).html(modalFooterHTML);
  $(modal).modal();
}
