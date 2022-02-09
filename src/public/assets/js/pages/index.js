var app = new Vue({
  el: "#app",
  data: {
    collapseShown: true,
  },
  methods: {
    toggleAllCollapse: function () {
      if (this.collapseShown) {
        $(".collapse").collapse("hide");
      } else {
        $(".collapse").collapse("show");
      }

      this.collapseShown = !this.collapseShown;
    },
  },
});