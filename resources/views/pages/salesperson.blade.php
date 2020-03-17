@extends('layout')

@section('content')

<div class="container">
  <h1>Vendedores</h1>

  <div v-if="Object.entries(salespersonError).length">
    <div class="alert alert-danger" role="alert">
      <p>Falha ao validar formulário:</p>
      <ul>
        <li v-for="item in salespersonError">@{{ item }}</li>
      </ul>
    </div>
  </div>

  <div class="form-inline">
    <div class="form-group mb-2 mr-2">
      <label for="name" class="sr-only">Vendedor</label>
      <input type="text" class="form-control" v-model="spName" placeholder="Nome vendedor">
    </div>
    <div class="form-group mb-2 mr-2">
      <label for="email" class="sr-only">Email</label>
      <input type="email" class="form-control" v-model="spEmail" placeholder="E-mail">
    </div>
    <button v-on:click="addSalesperson" class="btn btn-secondary mb-2 mr-2">Adicionar</button>
  </div>

  <table class="table mt-4">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Comissão %</th>
        <th>Comissão R$</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="sp in salesperson">
        <td>@{{ sp.id }}</td>
        <td>@{{ sp.name }}</td>
        <td>@{{ sp.email }}</td>
        <td>@{{ sp.commission_percent }}</td>
        <td>@{{ sp.commission_total }}</td>
      </tr>
    </tbody>
  </table>
</div>

@stop
