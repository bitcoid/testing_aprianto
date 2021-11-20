<template>
<div class="q-pa-md">
    <q-dialog :value="value" 
      @input="$emit('input')" persistent transition-show="scale" transition-hide="scale"
      ref="defaultDialog"
      >
      <q-card class="text-white" style="max-width: 1500px;width:1200px; height:600px;">
          <q-bar class="bg-blue-grey">
            Form Permintaan Barang 
          <q-space />

          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section> </q-card-section>

        <q-card-section class="q-pt-none text-black"> 
                <div class="row">
                    <div class="col-4 q-pa-xs"> NIK PEMINTA</div>
                    <div class="col-4 q-pa-xs"> NAMA </div>
                    <div class="col-4 q-pa-xs"> DEPARTEMENT</div>
                </div>
                <div class="row">
                    <div class="col-4 q-pa-xs"> 
                        <v-select 
                         v-model="id_employee"  
                         :options="optionsemployee" 
                         @search="fetchOptions"
                         :filterable="true"
                         label ="nik"
                         value="id"
                         style="background: white;"
                         @input="(item) => isikolominputan()" 
                         ref="id_employee" 
                        > 
                        </v-select> 
                    </div>
                    <div class="col-4 q-pa-xs">  
                       <q-input dense outlined v-model="nama_karyawan"  bg-color="grey-2" :disable="true" class="super-small" />
                    </div>
                    <div class="col-4 q-pa-xs"> 
                        <q-input dense outlined v-model="departemen_karyawan" bg-color="grey-2" :disable="true" class="super-small"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 q-pa-xs"> TGL. PERMINTAAN</div> 
                </div>
                <div class="row">
                    <div class="col-4 q-pa-xs"> 
                         <q-input dense bg-color="white" 
                           v-model="tgl_request" 
                           outlined
                           class="super-small"
                           >
                            <template v-slot:append>
                                <q-icon name="event" class="cursor-pointer" style="width:40px;">
                                <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                                    <q-date v-model="tgl_request" mask="YYYY-MM-DD HH:mm">
                                    <div class="row items-center justify-end">
                                        <q-btn v-close-popup label="Close" color="primary" flat />
                                    </div>
                                    </q-date>
                                </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                    </div> 
                </div>
                <q-separator class="q-mt-md"/>
                <div class="row q-mt-md">
                    <div class="col-12">
                        <div class="text-subtitle2 text-bold"> DAFTAR BARANG </div>
                    </div>
                    <div class="col-12">
                        <tables :tgl_request="txt_tgl_request" :id_employee="txt_id_employee" :closeDialogAfterSubmit="closeDialogAfterSubmit" />
                    </div> 
                </div> 
        </q-card-section> 
      </q-card>
    </q-dialog>
    </div>
</template>

<script> 
import tables from './tables_request.vue'
export default {
  name: "windowpermintaan",
  props:{
    value : Boolean
  },
  components:{ tables },
  data(){
    return { 
        onDialogHide : false,
        tgl_request :'',
        id_employee : '',
        nama_karyawan : '',
        departemen_karyawan : '',
        optionsemployee :[],
        txt_tgl_request : '',
        txt_id_employee : ''
    }
  },
  watch:{
     id_employee(e){ 
         if(e){
              this.txt_id_employee = e.id
         }else{
              this.txt_id_employee = ''
         }
        
     },
     tgl_request(e){    
         if(e){
              this.txt_tgl_request = e 
         }else{
              this.txt_tgl_request = ''
         }
         
     }
  },
  methods:{
    fetchOptions (search, loading) {
    //  ... do some asynchronous stuff!  
        const payload = {
            'filters' : search
        }
        this.$store.dispatch('transaksi/actionSearchKaryawan', payload).then( response => {  
           this.optionsemployee = response.data.data
        }).catch(err =>{
            console.log(err)
        })  
    },
    isikolominputan (){ 
       if(this.id_employee !== null){
         this.nama_karyawan =  this.id_employee.nama
         this.departemen_karyawan = this.id_employee.department
       }else{
         this.id_employee = ''
         this.nama_karyawan =  ''
         this.departemen_karyawan = ''
       }
       
    }, 
    closeDialogAfterSubmit(){
      this.$refs.defaultDialog.hide()
      this.tgl_request = this.SetCurrentDate()
      this.id_employee = ''
    },
    SetCurrentDate(){
        let d = new Date() 
        let period =  d.getFullYear() + "-" +
                        ("00" + (d.getMonth() + 1)).slice(-2) + "-" +
                        ("00" + d.getDate()).slice(-2) + "-" +
                        
                        ("00" + d.getHours()).slice(-2) + ":" +
                        ("00" + d.getMinutes()).slice(-2)   
        return period
    }
  },
  mounted(){ 
      this.tgl_request = this.SetCurrentDate()
 
  } 
}
</script>  