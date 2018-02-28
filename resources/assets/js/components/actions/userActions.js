import axios from 'axios';

export function fetchUserComplaints(startDate, endDate) {
  return dispatch => {
    dispatch({ type: 'FETCH_USER_COMPLAINTS' });

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

export function postComplaint(title, description, image_url) {
  return dispatch => {
    dispatch({ type: 'POST_COMPLAINT' });

    axios
      .post('/api/v1/complaints', {
        title: title,
        description: description,
        image_url: image_url
      })
      .then(response => {
        dispatch({ type: 'POST_COMPLAINT_FULFILLED', payload: response.data });
      })
      .catch(err => {
        dispatch({ type: 'POST_COMPLAINT_REJECTED', payload: err });
      });
  };
}
