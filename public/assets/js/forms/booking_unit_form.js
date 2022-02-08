const app = new Vue({
  el: '#app',
  data: {
    model_id: null,
    bookables: [],
    model_id_container: 'div[data-label="container_model_id"]',
    bookable_id_container: 'div[data-label="container_bookable_id"]',
  },
  methods: {
    setData: function () {
      this.warehouse_id = old.model_id ? old.model_id : $(`${this.model_id_container} select`).val();
      if (data.item) {
        this.warehouse_id = data.item.bookable.warehouse_id;
      }
    },
    initFields: function () {
      $('#model_id').on('change', (e) => {
        this.warehouse_id = e.target.value;
        this.onModelChange();
      });
    },
    onModelChange: async function () {
      if (!this.warehouse_id) {
        return;
      }

      const response = await sendRequest(data.urls.getUnitsByModel, { warehouse_id: this.warehouse_id }, 'GET');
      this.bookables = response.data.units;

      this._resetBookablesSelect();
    },
    _resetBookablesSelect: function () {
      let html = '';
      html += `<option value="">Select</option>`;

      $(this.bookable_id_container).find('option').remove();

      $.each(this.bookables, (index, bookable) => {
        let value = bookable.id;
        let text = bookable.title;
        let selected = false;
        if (!data.item && old) {
          selected = value == old.bookable_id;
        } else if (data.item) {
          selected = value == item.bookable_id;
        }

        html += `<option value="${value}" ${selected ? 'selected' : ''}>${text}</option>`;
      });

      $(this.bookable_id_container + ' .selectpicker').append(html);
      $(this.bookable_id_container + ' .selectpicker').selectpicker('refresh');
    },
  },
  mounted() {
    this.setData();
    this.initFields();
    this.onModelChange();
  },
});
