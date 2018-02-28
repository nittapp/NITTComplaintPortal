import { combineReducers } from 'redux';

import { reducer as form } from 'redux-form';

import complaints from './complaintsReducer';
import newComplaint from './newComplaintReducer';

export default combineReducers({
  form,
  newComplaint,
  complaints
});
