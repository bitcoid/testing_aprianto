<template>
<div class="q-pa-md">
    <q-dialog :value="value" 
      @input="$emit('input')" persistent transition-show="scale" transition-hide="scale"
      ref="defaultDialog"
      >
      <q-card class="text-white" style="max-width: 1500px;width:1200px; height:600px; ">
          <q-bar class="bg-blue-grey">
            Preview Permintaan Barang 
          <q-space />

          <q-btn dense flat icon="close" v-close-popup>
            <q-tooltip class="bg-white text-primary">Close</q-tooltip>
          </q-btn>
        </q-bar>

        <q-card-section> </q-card-section>

        <q-card-section class="q-pt-none text-black "> 
            <div class="row">
                    <div class="col-4 q-pa-xs text-bold"> NIK PEMINTA</div>
                    <div class="col-4 q-pa-xs text-bold"> NAMA </div>
                    <div class="col-4 q-pa-xs text-bold"> DEPARTEMENT</div>
            </div>
            <div class="row">
                    <div class="col-4 q-pa-xs">  
                        {{ this.DataTransaction !== undefined ?  this.DataTransaction[0].nik : '' }}
                    </div>
                    <div class="col-4 q-pa-xs">  
                       {{ this.DataTransaction[0].nama }}
                    </div>
                    <div class="col-4 q-pa-xs"> 
                        {{ this.DataTransaction[0].department }}
                    </div>
            </div>
            <div class="row">
                    <div class="col-12 q-pa-xs text-bold"> TGL. PERMINTAAN</div> 
                    <div class="col-12 q-pa-xs"> {{ this.DataTransaction[0].tgl_request }} </div> 
            </div> 
            <q-separator class="q-mt-md"/>
                <div class="row q-mt-md">
                    <div class="col-12">
                        <div class="text-subtitle2 text-bold"> DAFTAR BARANG </div>
                    </div>
                    <div class="col-12"> 
                         <q-table  
                            :data="DataTransRequest"
                            :columns="columns"
                            row-key="index" 
                            color="amber"
                            :pagination.sync="pagination"
                            :loading ="isLoading"
                            :rows-per-page-options="[0]"  
                            flat
                          >
                          
                          <template v-slot:body="props">
                            <q-tr
                              :key="props.row.nama_item"
                              :props="props" 
                            >
                              <q-td>{{ props.row.nama_item }}</q-td> 
                              <q-td>{{ props.row.lokasi }}</q-td>
                              <q-td>{{ props.row.qty }}</q-td>
                              <q-td>{{ props.row.satuan }}</q-td>
                              <q-td>{{ props.row.ket }}</q-td> 

                            </q-tr>
                              
                          </template>

                          </q-table>
                    </div> 
            </div>      
                  
        </q-card-section> 
        </q-card>
      </q-dialog>
    </div>
</template>

<script>  
const columns = [
  {
    name: 'nama_item', 
    label: 'BARANG',
    align: 'left', 
    sortable: true
  },
  { name: 'lokasi', align: 'left', label: 'LOKASI', sortable: true }, 
  { name: 'qty', align: 'left',label: 'KUANTITI',  },
  { name: 'satuan', align: 'left',label: 'SATUAN'},
  { name: 'ket', align: 'left',label: 'KET'}  
] 
import { mapGetters } from 'vuex' 
export default {
  name: "windowpermintaan",
  props:{
    value : Boolean
  },
  components:{   },
  data(){
    return {  
      columns : columns,
      rows :[],
      isLoading : false,
      pagination: {
          sortBy: "id",
          descending: true,
          page: 1,
          rowsPerPage: 1 
      },
    }
  },
  computed:{
     ...mapGetters({
            DataTransaction : 'transaksi/getDataTransaction', 
            DataTransRequest : 'transaksi/getDataBarangRequest',
        })
  },
  watch:{
     
  },
  methods:{
     
  },
  mounted(){  
       
  } 
}
</script>  