
// <form id="form_add_anexo" enctype="multipart/form-data">
//     {{ csrf_field() }}
//     <div class="form-group">
//         <div class="col-md-8 form-group">
//             <label for="nome"> Nome do anexo: * </label>
//             <input name="nome" id="nome" class="form-control" required>
//         </div>
//         <input type="hidden" name="data_envio" id="data_envio" value="{{ Carbon::now() }}">

//         <div class="col-md-2">
//             <div class="form-group">
//                 <label for="anexo"> Anexo * </label>
//                 <input type="file"  name="anexo" id="anexo" class="form-control"   required>
//             </div>
//         </div>
//         <div class="col-md-2">
//             <div class="form-group" style="padding: 25px 0px 0px 0px;">  
//                 <button class="form-control btn btn-primary form-control button_default"  @click.prevent="add_anexo()"> Adicionar anexo </button>
//             </div>
//         </div>  
//     </div>
// </form> 

new Vue({
    el:'#app',
    data:{
        anexos: '',
            contrato_id: '{{ $contrato->id }}',
            api_token: "{!! env('API_KEY')!!}", 
    },
    methods:{
            add_anexo: function() {
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                let form = new FormData();
                form.append("id",   $("#id").val());
                form.append("nome", $("#nome").val());
                form.append("data_envio", $("#data_envio").val());
                form.append('anexo', document.querySelector('#anexo').files[0]);
                form.append('api_token', this.api_token);
                axios.post("/api/contratos/empresa/anexo/add", form ,config )
                    .then(response => {
                        this.get_anexos();
                    })
                    .catch(error => {
                        console.log(error);
                        alert("Ops! Não consegui gravar os dados!");
                    });

            },
    },
});


//Código Laravel:
// api.php 
/* Api's de anexos do contrato empresa */
//Route::post('/contratos/empresa/anexo/add',  'Admin\AnexoController@apiAnexoContratoStore')->middleware('api_token');
/* */
// public function apiAnexoContratoStore(Request $request)
// {
//     $contrato = Contrato::find($request->id);
//     $dadosFormulario = $request->all();
//     $nomeArquivo = rand(1,999) . '_'.$request->anexo->getClientOriginalName();
//     $request->anexo->storeAs('/public/arquivos_contratos', $nomeArquivo, 'local'); // Ação de gravar
//     $dadosFormulario['anexo'] = '/storage/arquivos_contratos/' . $nomeArquivo;
   
//     $contrato->anexos()->create([
//         'nome' => $dadosFormulario['nome'],
//         'anexo' => $dadosFormulario['anexo'],
//         'data_envio' => $dadosFormulario['data_envio']  
//     ]); 
// }