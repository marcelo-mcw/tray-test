@extends('layout')

@section('content')

<div class="container">
  <h1>Vendas</h1>

  <div v-if="Object.entries(saleErrors).length">
    <div class="alert alert-danger" role="alert">
      <p>Falha ao validar formulário:</p>
      <ul>
        <li v-for="item in saleErrors">@{{ item }}</li>
      </ul>
    </div>
  </div>

  <div class="form-inline">
    <div class="form-group mb-2 mr-2">
      <label for="id_salesperson" class="sr-only">Vendedor</label>
      <select class="form-control" v-model="sIdSalesperson" name="id_salesperson" @change="setSale">
        <option selected disabled>Vendedor</option>
        <option v-for="item in salesperson" v-bind:value="item.id" >@{{ item.name }}</option>
      </select>
    </div>
    <div class="form-group mb-2 mr-2">
      <label for="total" class="sr-only">Valor da venda</label>
      <vue-mask class="form-control" v-model="sTotal" name="total" mask="#.##0,00" placeholder="Valor da venda" :options="options"></vue-mask>
    </div>
    <button v-on:click="addSale" class="btn btn-secondary mb-2 mr-2">Adicionar</button>
  </div>

  <div class="table-responsive">
    <table class="table mt-4">
      <thead>
        <tr>
          <th>ID vendedor</th>
          <th>Nome vendedor</th>
          <th>E-mail vendedor</th>
          <th>Comissão % vendedor</th>
          <th>ID venda</th>
          <th>Data venda</th>
          <th>Total R$ venda</th>
          <th>Comissão R$ venda</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in sale">
          <td>@{{ item.salesperson_id }}</td>
          <td>@{{ item.salesperson_name }}</td>
          <td>@{{ item.salesperson_email }}</td>
          <td>@{{ item.salesperson_commission }}</td>
          <td>@{{ item.sale_id }}</td>
          <td>@{{ item.sale_date }}</td>
          <td><b>@{{ item.sale_total }}</b></td>
          <td><b>@{{ item.sale_commission }}</b></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@stop
