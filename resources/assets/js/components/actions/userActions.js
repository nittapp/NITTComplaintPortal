import axios from 'axios';
export function fetchUserComplaints() {
  return dispatch => {
    dispatch({ type: 'FETCH_USER_COMPLAINTS' });
    //TODO - CHANGE TO 8080.
    axios
      .get('/api/v1/complaints')
      .then(response => {
        dispatch({
          type: 'FETCH_USER_COMPLAINTS_FULFILLED',
          payload: response.data
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_USER_COMPLAINTS_REJECTED', payload: err });
      });
  };
}

//TODO: Work with image_url
export function postComplaint(title, description, image_url) {
  return dispatch => {
    dispatch({ type: 'POST_COMPLAINT' });
    var bodyFormData = new FormData();
    bodyFormData.set('title', title);
    bodyFormData.set('description', description);
    bodyFormData.set('image', image_url);
    axios({
        method: 'post',
        url: '/api/v1/complaints',
        data: bodyFormData,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
    })
      .then(response => {
        dispatch({ type: 'POST_COMPLAINT_FULFILLED', payload: response.data });
      })
      .catch(err => {
        dispatch({ type: 'POST_COMPLAINT_REJECTED', payload: err.data });
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
    dispatch({ type: 'FETCH_USER_COMMENTS' });
    axios
      .get('/api/v1/comments/'+id)
      .then(response => {
        dispatch({
          type: 'FETCH_USER_COMMENTS_FULFILLED',
          payload: response.data.data,
          complaintId: id
        });
      })
      .catch(err => {
        dispatch({ type: 'FETCH_USER_COMMENTS_REJECTED', payload: err });
      });
  };
}

export function updateComplaint(complaint_id,title, description, image_url) {
  return dispatch => {
    dispatch({ type: 'UPDATE_COMPLAINT' });
    var bodyFormData = new FormData();
    bodyFormData.set('title', title);
    bodyFormData.set('description', description);
    bodyFormData.set('image', image_url);
    bodyFormData.set('complaint_id',complaint_id);
    axios({
        method: 'post',
        url: '/api/v1/complaints/edit',
        data: bodyFormData,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
    })
      .then(response => {
        dispatch({ type: 'UPDATE_COMPLAINT_FULFILLED', payload: response.data });
      })
      .catch(err => {
        dispatch({ type: 'UPDATE_COMPLAINT_REJECTED', payload: err.data });
      });
  };
}