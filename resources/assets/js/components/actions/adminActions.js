import axios from 'axios';

export function fetchAllComplaints() {
  return dispatch => {
    dispatch({ type: 'FETCH_ALL_COMPLAINTS' });

    axios
      .get('/api/v1/complaints')
      .then(response => {
        console.log(response.data);
        dispatch({
          type: 'FETCH_ALL_COMPLAINTS_FULFILLED',
          payload: response.data
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_ALL_COMPLAINTS_REJECTED', payload: err });
      });
  };
}

export function changeComplaintStatus(complaint_id,status_id) {

  return dispatch => {
    dispatch({ type: 'CHANGE_COMPLAINT_STATUS' });

    axios
      .put('/api/v1/admin/complaints/status',{
        complaint_id : complaint_id,
        status_id : status_id
      })
      .then(response => {
        console.log(response.data);
        dispatch({
          type: 'CHANGE_COMPLAINT_STATUS_FULFILLED',
          payload: response.data
        });
      })
      .catch(err => {
        dispatch({ type: 'CHANGE_COMPLAINT_STATUS_REJECTED', payload: err });
      });
  };
}
export function fetchAllComplaintStatus(){
  return dispatch => {
    dispatch({ type: 'FETCH_ALL_STATUS' });

    axios
      .get('/api/v1/admin/statuses')
      .then(response => {
        console.log(response.data);
        dispatch({
          type: 'FETCH_ALL_STATUS_FULFILLED',
          payload: response.data
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_ALL_STATUS_REJECTED', payload: err });
      });
  };


}


