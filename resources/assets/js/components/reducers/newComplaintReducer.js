export default function reducer(
  state = {
    loading: false,
    complaintPosted: false,
    error: null
  },
  action
) {
  switch (action.type) {
    case 'POST_COMPLAINT': {
      return {
        ...state,
        loading: true
      };
    }
    case 'POST_COMPLAINT_FULFILLED': {
      return {
        ...state,
        complaintPosted: true,
        loading: false
      };
    }
    case 'POST_COMPLAINT_REJECTED': {
      return {
        ...state,
        error: action.payload,
        loading: false
      };
    }
    default:
      return state;
  }
}
