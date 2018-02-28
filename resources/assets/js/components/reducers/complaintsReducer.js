export default function reducer(
  state = {
    loading: false,
    complaints: [],
    statuses:[],
    error: null
  },
  action
) {
  switch (action.type) {
    case 'FETCH_PUBLIC_COMPLAINTS': {
      return { ...state, loading: true };
    }
    case 'FETCH_PUBLIC_COMPLAINTS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }
    case 'FETCH_PUBLIC_COMPLAINTS_FULFILLED': {
      var complaints = action.payload;
      for (let complaint of complaints) {
        complaint.comments = [];
        complaint.commentsLoading = false;
      }
      return {
        ...state,
        loading: false,
        complaints: complaints
      };
    }
    case 'FETCH_COMMENTS': {
      return { ...state, loading: true };
    }
    case 'FETCH_COMMENTS_FULFILLED': {
      return {
        ...state,
        loading: false,
        complaints: state.complaints.map((item, index) => {
          if (item.id !== action.complaintId) {
            return item;
          }
          return {
            ...item,
            comments: action.payload
          };
        })
      };
    }
    case 'FETCH_COMMENTS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }
    case 'FETCH_ALL_STATUS' : {
      return {...state,loading:true };
    }
    case 'FETCH_ALL_STATUS_FULFILLED' : {
      var statuses = action.payload.data;
      return {
        ...state,
        loading: false,
        statuses: statuses
      };

    }

    case 'CHANGE_COMPLAINT_STATUS':{
      return {...state,loading:true};
    }

    case 'CHANGE_COMPLAINT_STATUS_FULFILLED':{
      return{...state,loading:false};
    }
    case 'CHANGE_COMPLAINT_STATUS_REJECTED':{
      return{...state,loading:false,error:action.payload};
    }
    default:
      return state;
  }
}
