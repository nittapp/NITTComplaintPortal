import axios from 'axios';

export function fetchPublicComplaints() {
  return dispatch => {
    dispatch({ type: 'FETCH_PUBLIC_COMPLAINTS' });

    axios
      .get('/api/v1/complaints/public')
      .then(response => {
        dispatch({
          type: 'FETCH_PUBLIC_COMPLAINTS_FULFILLED',
          payload: response.data.data
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_PUBLIC_COMPLAINTS_REJECTED', payload: err });
      });
  };
}


export function fetchComments(id) {
  return dispatch => {
    dispatch({ type: 'FETCH_COMMENTS' });
    axios
      .get('/api/v1/comments/'+id)
      .then(response => {
        dispatch({
          type: 'FETCH_COMMENTS_FULFILLED',
          payload: response.data.data,
          complaintId: id
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_COMMENTS_REJECTED', payload: err });
      });
  };
}
