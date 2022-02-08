const app = new Vue({
  el: '#app',
  data: {
    type: null,
    type_container: 'div[data-label="container_type"]',
    image_container: 'div[data-label="container_image"]',
    video_container: 'div[data-label="container_video"]',
    video_thumbnail_container: 'div[data-label="container_video_thumbnail"]',
  },
  methods: {
    setData: function () {
      this.type = item ? item.type : old.type;
      if (item) {
        this.type = item.type ? item.type : old.type;
      } else {
        this.type = $(`${this.type_container} select`).val();
      }
    },
    initFields: function () {
      $('#type').on('change', (e) => {
        let value = e.target.value;
        this.type = value;

        this.onTypeChange();
      });
    },
    onTypeChange: function () {
      if (this.type == 'image') {
        $(this.image_container).show();
        $(this.video_container).hide();
        $(this.video_thumbnail_container).hide();
      } else if (this.type == 'video') {
        $('#discount_type_id').val('').selectpicker('refresh');
        $(this.image_container).hide();
        $(this.video_container).show();
        $(this.video_thumbnail_container).show();
      }
    },
  },
  mounted() {
    this.setData();
    this.initFields();
    this.onTypeChange();
  },
});
