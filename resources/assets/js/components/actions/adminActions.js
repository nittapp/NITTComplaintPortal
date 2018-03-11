import axios from 'axios';

export function fetchAllComplaints() {
  return dispatch => {
    dispatch({ type: 'FETCH_ALL_COMPLAINTS' });
    //TODO - CHANGE TO 8080.
    axios
      .get('/api/v1/admin/complaints/')
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

export function changeComplaintStatus(complaint_id, status_id) {
  return dispatch => {
    dispatch({ type: 'CHANGE_COMPLAINT_STATUS' });

    axios
      .put('/api/v1/admin/complaints/status', {
        complaint_id: complaint_id,
        status_id: status_id
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
export function fetchAllComplaintStatus() {
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
export function postComment(complaintId, comment) {
  return dispatch => {
    dispatch({ type: 'POST_COMMENT' });

    axios
      .post('/api/v1/comments/', {
        complaint_id: complaintId,
        comment: comment
      })
      .then(response => {
        console.log(response.data);
        dispatch({ type: 'POST_COMMENT_FULFILLED', payload: response.data });
      })
      .catch(err => {
        dispatch({ type: 'POST_COMMENT_REJECTED', payload: err });
      });
  };
}

export function fetchComments(id) {
  return dispatch => {
    dispatch({ type: 'FETCH_ADMIN_COMMENTS' });
    axios
      .get('/api/v1/comments/'+id)
      .then(response => {
        dispatch({
          type: 'FETCH_ADMIN_COMMENTS_FULFILLED',
          payload: response.data.data,
          complaintId: id
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_ADMIN_COMMENTS_REJECTED', payload: err });
      });
  };
}

export function toggleComplaintView(id){
    return dispatch => {
        dispatch({type: 'TOGGLE_PUBLIC_VISIBILTY'});
        axios
        .put('/api/v1/admin/complaints/'+id+'/public')
        .then(response => {
            dispatch({
              type: 'TOGGLE_PUBLIC_VISIBILTY_SUCCESSFUL',
              payload: response.data.data
            });
          })
        .catch(err => {
            dispatch({ type: 'TOGGLE_PUBLIC_VISIBILTY_REJECTED', payload: err });
        });
    }
}