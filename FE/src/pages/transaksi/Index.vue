<template>
  <div class="layout q-pt-md q-mb-xl q-pa-sm">
        <div class="row">
          <div class="col-12 q-pa-sm">
            <q-btn color="secondary" 
             text-color="white" 
             label="Tambah Permintaan" 
             @click="Add" 
            />
          </div>
           <div class="col-12 q-pa-sm"> 
             <q-table 
                title="Permintaan Barang"
                :data="rows"
                :columns="columns"
                row-key="index" 
                dark
                color="amber"
                :pagination.sync="pagination"
                :loading ="isLoading"
                :rows-per-page-options="[0]"
                :filter="filter"
                @request="onRequest"
              >
               
              <template v-slot:body="props">
                <q-tr
                  :key="props.row.id"
                  :props="props" 
                >
                  <q-td>{{ props.row.nik }}</q-td>
                  <q-td>{{ props.row.nama }}</q-td>
                  <q-td>{{ props.row.department }}</q-td>
                  <q-td>{{ props.row.tgl_request }}</q-td>
                  <q-td>{{ props.row.jml_brg }}</q-td>
                  <q-td>
                  <q-btn
                    no-caps
                    flat
                    color="teal-5"
                    icon="visibility"
                    @click="onView(props.row.id)"
                  />
                </q-td>

                </q-tr>
                  
              </template>

              </q-table> 
           </div>
        </div>
        <windowrequest v-model="dialog"/> 
        <windowrequest-view v-model="dialogView" /> 
  </div>
</template>

<script> 
const columns = [
  {
    name: 'nik',
    required: true,
    label: 'NIK Karyawan',
    align: 'left', 
    sortable: true
  },
  { name: 'nama', align: 'left', label: 'Nama', sortable: true },
  { name: 'department',align: 'left', label: 'Departement', sortable: true },
  { name: 'tgl_request', align: 'left',label: 'Tgl. Permintaan',  },
  { name: 'jml_brg', align: 'left',label: 'Jml Barang'},
  {  align: 'left',label:'Action'} 
]  
import Windowrequest from './windowrequest.vue';
import WindowrequestView from './windowrequestview.vue';

export default {
  name: "Transaksi", 
  components:{
    Windowrequest , WindowrequestView
  },
  data() {
    return {
       columns : columns,
       rows : [],
       isLoading : false,
       filter  :'',
       pagination: {
          sortBy: "id",
          descending: true,
          page: 1,
          rowsPerPage: 1,
          rowsNumber: 0, 
      },

      dialog : false,
      dialogView : false
    } 
  },
  computed: {
     
  },
  methods:{
      Add(){
         this.dialog = true  
      },
      onView(IdTransaction){
          this.$store.commit('transaksi/setIdTransaction', IdTransaction) //it's only for views, we use same windows sajah...
          this.$store.dispatch('transaksi/actionViewHeaderRequest').then(Response =>{ 
              this.$store.commit('transaksi/setdataTransaction', Response.data.data)  
          }) 
          this.$store.dispatch('transaksi/actionViewBodyRequest').then(Response =>{ 
              this.$store.commit('transaksi/setBarangRequest', Response.data.data.data)  
          }) 
          this.dialogView = true
      },
      getList(page){ 
        const payload = {
            page : page
        }
        this.isLoading = true
        this.$store.dispatch('transaksi/actionShowList', payload).then( response => { 
            this.rows = response.data.data.data   
            this.pagination.rowsNumber = response.data.data.last_page
            this.isLoading = false
        }).catch(err =>{
            this.isLoading = false
        }) 
     },
     onRequest(props){
      let { page, rowsPerPage, rowsNumber, sortBy, descending } = props.pagination
       this.isLoading = true
       setTimeout(() => { 
        // update rowsCount with appropriate value
        rowsNumber = this.getRowsNumberCount(this.filter)
 
        // calculate starting row of data
        const startRow = (page - 1) * rowsPerPage
 
        this.getList(startRow + 1)

        // don't forget to update local pagination object
        this.pagination.page = page
        this.pagination.rowsPerPage = rowsPerPage
        this.pagination.sortBy = sortBy
        this.pagination.descending = descending 

        // ...and turn of loading indicator
        this.isLoading = false
      }, 1500)
      
     },
     getRowsNumberCount (filter) {
       console.log(this.rowsNumber)
      if (!filter) {
        return this.rows.length
      }
      let count = 0
      this.rows.forEach((treat) => {
        if (treat['name'].includes(filter)) {
          ++count
        }
      })
      return count
    }
  },
  mounted(){ 
    
    this.onRequest({
      pagination: this.pagination 
    }) 
  }

};
</script>

<style lang="scss">
.q-responsive {
  margin-top: 0px !important;
}
</style>
