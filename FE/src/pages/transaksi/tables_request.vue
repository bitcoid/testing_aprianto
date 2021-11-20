<template>
    <div class="q-mt-sm">
     <q-markup-table class="bg-grey-3">
      <thead>
        <tr>
          <th class="text-left">#</th>  
          <th class="text-left" width="40%">BARANG</th>
          <th class="text-left" width="10%">LOKASI</th>
          <th class="text-left" width="5%">TERSEDIA</th>
          <th class="text-left" width="10%">KUANTITI</th>
          <th class="text-left">SATUAN</th>
          <th class="text-left" width="15%">KET</th>
          <th class="text-left" width="5%">STATUS</th>
          <th class="text-left" width="5%">#</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(input,k) in inputs" :key="k">
          <td class="text-left" valign="top">{{ k+1 }}</td>
          <td class="text-left" valign="top">
               <v-select 
                         v-model="input.name"  
                         :options="option_brg"
                         @search="fetchOptions"  
                         :filterable="true"
                         label ="nama"
                         value="id"
                         style="background: white;" 
                         @input="(item) => InputBarang(input, k)"  
                        > 
                        </v-select>  
              
          </td>
          <td class="text-left" valign="top">
              <q-input v-if="input.name" outlined dense v-model="input.lokasi" 
              :disable="true" bg-color="teal-3" class="super-small"/>
          </td>
          <td class="text-center" valign="top">
              <q-input v-if="input.name" outlined dense v-model="input.tersedia" 
              :disable="true" bg-color="teal-3"  class="super-small"/>
          </td>
          <td class="text-left" valign="top">
              <q-input v-if="input.name" outlined dense type="number"
              v-model="input.kuantiti" min="0" @change="funcqty(input, k )" 
              class="super-small" bg-color="white"/>
          </td>
          <td class="text-center" valign="top"> 
            <q-input v-if="input.name" outlined dense v-model="input.satuan" 
              :disable="true" bg-color="teal-3"  class="super-small"/>
          </td>
          <td class="text-center" valign="top">
             <q-input v-if="input.name" outlined dense v-model="input.ket" 
              bg-color="white"  class="super-small"/>
          </td>
          <td class="text-center" valign="top" v-if="input.name"> 
             <span :ref="'status_'+ k" style="font-size:10px;"></span> 
          </td>
          <td class="text-left"  valign="top" v-if="input.name"> 
              <q-icon name="delete" dense class="text-red"
               @click="remove(k)" v-show="k || ( !k && inputs.length > 1)" style="cursor:pointer; font-size: 1.5rem;"
              />
              <q-icon name="local_hospital" class="text-green" 
                @click="add(k)" v-show="k == inputs.length-1" style="cursor:pointer; font-size: 1.5rem;"
              /> 
          </td>
        </tr>
        <tr>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
       <tr>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
         
      </tbody>
    </q-markup-table> 
      <div class="text-center q-mt-xs">
        <q-btn-group push>
          <q-btn @click="submit()" :disabled="onActiveSubmit" color="yellow" glossy text-color="black" push label="Proses" icon="description" />
          <q-btn color="amber" glossy text-color="black" push label="Batal" icon="logout" @click="this.closeDialogAfterSubmit"/> 
        </q-btn-group>
      </div>
    </div>
</template>


<script> 
export default {
  name: "tables",
  props:['tgl_request','id_employee','closeDialogAfterSubmit'] ,
  data(){ 
    return { 
        inputs: [{
            name: '',
            lokasi: '',
            tersedia : '',
            kuantiti : '',
            satuan :'',
            ket :''
        }],
        option_brg :[], 
        onActiveSubmit : false
    }
  },
  methods:{
        add (k) {
            this.inputs.push({
                name: '',
                lokasi: '',
                tersedia : '',
                kuantiti : '',
                satuan :'',
                ket :''
            })

           
            //cek ketersediaan ada yg kosong di array ?
            let init = this.checkValidStok(this.inputs) 
            if(init === 1) //ada yg 0
              this.onActiveSubmit = true 
        },

        remove (index) {
           this.inputs.splice(index, 1)
        },
        fetchOptions (search, loading) {
            //  ... do some asynchronous stuff!   
        },
        InputBarang(selected, k) { 
          if(selected.name !== undefined) {
              selected.lokasi = selected.name.lokasi
              selected.tersedia = selected.name.stok
              selected.satuan = selected.name.satuan
              selected.kuantiti = ''
              selected.ket = '-' 
    
              let sArray = []  
              this.inputs.forEach((e) => {
                  sArray.push(e.name.id)  
              }) 
              
              if (this.hasDuplicates(sArray)) { 
                  this.$q.dialog({
                    dark: false,
                    title: 'Pesan Kesalahan',
                    message: 'Sepertinya Barang yang anda pilih sudah ada.'
                  }).onOk(() => {
                    // console.log('OK')
                    this.inputs.splice(k, 1)
                  }) 
              } 
          }
             
        }, 
        hasDuplicates(arr) {
            return arr.some(x => arr.indexOf(x) !== arr.lastIndexOf(x));
        }, 
        checkValidStok(vm){
            for(let i=0; i<vm.length;i++){ 
                if(vm[i].tersedia === 0){
                    return 1
                }
            }
        },
        funcqty(v,k){    
          if(v.kuantiti !== '' && parseInt(v.kuantiti) > 0){
              if(parseInt(v.tersedia) >= parseInt(v.kuantiti) && parseInt(v.kuantiti) > 0){
                this.$refs['status_' + k][0].innerHTML  = '<span class="bg-green q-pa-xs text-white text-caption">terpenuhi</span>'
                this.onActiveSubmit = false
              }else{
                if(parseInt(v.tersedia) < 0 || parseInt(v.tersedia) == 0){               
                  this.$refs['status_' + k][0].innerHTML  = '<span class="bg-red q-pa-xs text-white text-caption">kosong</span>'
                  this.onActiveSubmit = true
                }else{ 
                  this.$refs['status_' + k][0].innerHTML  = '<span class="bg-red q-pa-xs text-white text-caption">sebagian</span>'
                }
              } 
          }else{
              this.$refs['status_' + k][0].innerHTML  = ''
              this.onActiveSubmit = true
          }
           
        },
        submit(){ 
            let init = this.checkValidStok(this.inputs) 
            if(init === 1) {//ada yg 0
                alert('Tidak Dapat melanjutkan proses, Masih Ada data dengan stok 0')
                this.onActiveSubmit = true 
            }else{
                this.onActiveSubmit = false 
                let listbarang =[]
                this.inputs.forEach((val, index) => { 
                    if(val.name != ""){
                      let daftar = {
                          'id_barang' : val.name.id === undefined ? '' : val.name.id,
                          'qty' : val.kuantiti,
                          'satuan' : val.satuan,
                          'lokasi' : val.lokasi,
                          'ket' : val.ket 
                      }
                      listbarang.push(daftar)
                    }
                    //this.callbackListBarang (listbarang)
                })  
                 
                let payload = {
                    'tgl_request' :  this.tgl_request,
                    'id_employee' : this.id_employee,
                    'listbarang' : listbarang
                }   
                
                this.$store.dispatch('transaksi/actionSave', payload).then( Response => {
                     //return success  
                      this.$q.dialog({
                        dark: false,
                        title: 'Sukses',
                        message: Response.data.message
                      }).onOk(() => { 
                           this.closeDialogAfterSubmit();
                      }) 
                }).catch(e => {
                     
                     let errors = Object.values(e.response.data);
                     errors = errors.flat();
                     let msg = '';
                     errors.forEach((err)=> {
                        msg += err + '<br>'
                     })
                     this.$q.notify({ message : 'Gagal Melakukan proses data <br>' + msg , html: true , color: 'red'})
                     console.log(errors)
                })
                
            }
        } 
         
  },
  mounted(){
    this.$store.dispatch('transaksi/actionShowlistBarang').then(Response => { 
        this.option_brg = Response.data.data
    })
  },
  created(){
         
  },
}
</script>
 

