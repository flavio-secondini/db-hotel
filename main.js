Vue.config.devtools = true;

var app = new Vue ({
  el:'#root',
  data: {
    stanze: [],
    stanza: {},
  },
  mounted () {
    axios.get('http://localhost/db-hotel/api/stanze.php')
    .then((response) => {
      this.stanze = response.data.response;
    });
  },
  methods: {
    selezioneStanza: function (id) {
      axios.get('http://localhost/db-hotel/api/stanze.php?id='+id)
      .then((response) => {
        this.stanza = response.data.response;
      });
    }
  }
})
