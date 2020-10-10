@extends('layout.usersmenu')

		@section('conteudo')

				<h1>Venda</h1>
                <div id="app">
                <form>
                <label>Produto</label>
                    <select class="form-control">
                    <option v-for="produto in produtos" :value="produto.id">@{{ produto.name }}</option>
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
                <input name="uf" type="text" id="uf"    class="form-control"  :value="data.uf" /></label>

                <br>
                <button type="button" @click="addnovousuario" class="btn btn-primary">Add</button>
                </form>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Cliente</th>
                        <th>CPF</th> 
                        <th>Email</th>
       
                    </tr> 

                    
					<tr v-for="usuario in listUser">
						<td>@{{ usuario.name }} </td>
                        <td>@{{ usuario.cpf }} </td>
                        <td>@{{ usuario.email }} </td>

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
                        listUser: [],
                        nome: '',
                        cpf: '',
                        data: "",
                        cep: '',
                        endereco: '',
                        produtos: '',
                        novousuario:{
                            nome:"",
                            cpf: "",
                            email: "",
                        },

                    },
                    filters: {
                    },
                    computed: {
                    },
                    mounted() {  
                        const vm = this  
                        vm.listaProdutos()
                        
                    },
                    methods:{
                        listaUsuarios(){
                            const vm = this
                            axios.get('/listausuario').then((response)=>
                            vm.listUser = response.data

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
                                .then( response => vm.data = response.data )
                                .catch( error => console.log(error) )
                            }
                        
                        },
                        addnovousuario(){
                            const vm = this
                            console.log("add")
                            let data = {
                                nomenovo: vm.novousuario.nome,
                                cpfnovo: vm.novousuario.cpf,
                                emailnovo: vm.novousuario.email
                            }
                            axios.post('/novousuario', data).then(()=>{
                                vm.listaUsuarios();
                                vm.novousuario.nome = ""
                                vm.novousuario.cpf = ""
                                vm.novousuario.email = ""
                            })

                        }

                    }
                })
            }
             
            </script>


			@stop
            