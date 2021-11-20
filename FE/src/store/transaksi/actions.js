import { api } from "boot/axios";
 
export const actionShowList = async ({ rootGetters, commit }, payload) => { 
  const {page} = payload 
  return api.get('/transactionlist?page=' + page)
};

export const actionSearchKaryawan = async ({ rootGetters, commit }, payload) => {  
  const { filters } = payload
  return api.get('/searchkaryawan/?params=' + filters)
};

export const actionShowlistBarang = async ({ rootGetters, commit }) => {   
  return api.get('/baranglist')
};

/**
 * Store
 * @params form
 */
 export const actionSave = async ({ rootGetters, commit }, payload) => { 
  try{  
       const request = {
          'tgl_request' : payload.tgl_request !='' ? payload.tgl_request + ':00' : '',
          'karyawan_id'  : payload.id_employee, 
          'listbarang'  : payload.listbarang 
      };  
       let url = '/transaction'
       return api.post( url , request)
  }catch(err){
      console.log(err)
  }
};

export const actionViewHeaderRequest = async ({ rootGetters, commit }) => {  
  const IdTransaction = rootGetters['transaksi/getIdTransaction']  
  return api.get('/transactionViewHeader?id=' + IdTransaction)
};

export const actionViewBodyRequest = async ({ rootGetters, commit }) => {  
  const IdTransaction = rootGetters['transaksi/getIdTransaction']  
  return api.get('/transactionBaranglist?id=' + IdTransaction)
};