require('./bootstrap');

import Vue from 'vue';
import VuejQueryMask from 'vue-jquery-mask';

Vue.use(VuejQueryMask);

var app = new Vue({
  el: '#app',
  data: {
    sale: [],
    saleErrors: [],
    salesperson: [],
    salespersonError: [],
    spName: null,
    spEmail: null,
    sIdSalesperson: null,
    sTotal: null,
    options: {
      reverse: true
    }
  },
  created() {
    axios
      .get('/api/v1/vendedores')
      .then(response => (this.salesperson = response.data));
  },
  methods: {
    setSale: function () {
      let id_salesperson = this.sIdSalesperson;

      axios
        .get(`/api/v1/vendas?id_salesperson=${id_salesperson}`)
        .then(response => {
          this.sale = response.data;
        })
        .catch(error => (this.saleErrors = error.response.data));
    },
    addSale: function () {
      let id_salesperson = this.sIdSalesperson;
      let total          = this.sTotal ? this.sTotal / 100 : 0;
      let data           = this.sale;

      axios
        .post('/api/v1/venda', {
          id_salesperson: id_salesperson,
          total: total
        })
        .then(response => {
          data.push(response.data);

          this.sale       = [];
          this.saleErrors = [];

          this.sIdSalesperson = '';
          this.sTotal         = '';
        })
        .catch(error => (this.saleErrors = error.response.data));
    },
    addSalesperson: function () {
      let name  = this.spName;
      let email = this.spEmail;
      let data  = this.salesperson;

      axios
        .post('/api/v1/vendedor', {
          name: name,
          email: email
        })
        .then(response => {
          data.push(response.data);

          this.salesperson      = data;
          this.salespersonError = [];

          this.spName  = '';
          this.spEmail = '';
        })
        .catch(error => (this.salespersonError = error.response.data));
    }
  }
});
