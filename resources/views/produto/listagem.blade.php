@extends('layout.usersmenu')

		@section('conteudo')

				<h1>Venda</h1>
                <div id="app">
                <form>
                <label>Produto</label>
                    <select class="form-control" v-model="id_prod">
                    <option v-for="produto in produtos"  :value="produto.id">@{{ produto.name }}</option>
                    </select>
                    <br>
                <label>Endereço de entrega</label>
                <br>
                <label>CEP</label>
                <input type="text" class="form-control" @keyup="verificacep" name="cpfnovo" id="c" required placeholder="cep" v-model="cep">
                
                </br>
                <label>Rua:
                <input name="rua" type="text" id="rua" class="form-control" :value="data.logradouro" /></label>
                <label>Bairro:
                <input name="bairro" type="text" id="bairro" class="form-control" :value="data.bairro"/></label>
                <label>Cidade:
                <input name="cidade" type="text" id="cidade" class="form-control":value="data.localidade" /></label>
                <label>Estado:
                <input name="uf" type="text" id="uf" class="form-control"  :value="data.uf" /></label>

                <br>
                <button type="button" @click="addvenda" class="btn btn-primary">Adicionar Venda</button>
                </form>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Nome</th>
                        <th>Preco</th> 
                        <th>Fornecedor</th>
       
                    </tr> 

                    
					<tr v-for="vend in listVendas">
						<td>@{{ vend.name }} </td>
                        <td>@{{ vend.price }} </td>
                        <td>@{{ vend.nameP }} </td>

					</tr>

				</table>


                </div>

			<script src="/js/vue.js"></script>
            <script src="/js/axios.min.js"></script>
            <script>
            function transforReq(){
                this.transformRequest = (data, headers) => {
                if (data && typeof data === 'object'){
                    let formData = new FormData()
                    Object.keys(data).forEach(key => {
                        formData.append(key, data[key])
                    })
                    return formData
                }else{
                    return data
                }
            }
            }
            window.onload = function () {
                Vue.prototype.$http = axios.create({
                    baseURL: '<?php URL::to('/'); ?>',
                    transformRequest: transforReq()
	            })
                const app = new Vue({
                    el: '#app',
                    data: {
                        teste: "oi",
                        nome: '',
                        cpf: '',
                        data: "",
                        cep: '',
                        endereco: '',
                        produtos: '',
                        id_prod: '',
                        listVendas: [],
                    },
                    filters: {
                    },
                    computed: {
                    },
                    mounted() {  
                        const vm = this  
                        vm.listaProdutos()
                        vm.listaVendas()
                    },
                    methods:{
                        listaVendas(){
                            const vm = this
                            axios.get('/vendas').then((response)=>
                            vm.listVendas = response.data

                            )
                        },

                        listaProdutos(){
                            const vm = this
                            console.log("teste")
                            axios.get('/listaprodutos').then((response)=>
                            vm.produtos = response.data

                            )
                        },
                        verificacep(){
                            const vm = this
                            if(vm.cep.length == 8) {
                                axios.get(`https://viacep.com.br/ws/${ vm.cep }/json/`)
                                .then( (response) => vm.data = response.data )
                                .catch( error => console.log(error) )
                            }
                        
                        },
                        addvenda(){
                            const vm = this
                            vm.endereco = vm.data.logradouro+", "+vm.data.bairro+". "+vm.data.localidade+", "+vm.data.uf
                            let val = 20.20
                            let data = {
                                produto_id: vm.id_prod,
                                total: val,
                                address: vm.endereco
                            }
                            axios.post('/criavenda', data).then((response) => 
                            vm.listVendas = response
                            
                            )
                            vm.listaVendas()
                            
                        }

                    }
                })
            }
             
            </script>


			@stop
            