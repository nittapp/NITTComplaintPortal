export default function reducer(
  state = {
    loading: false,
    complaints: [],
    user_complaints: [],
    all_complaints: [],
    statuses: [],
    error: null,
    complaintSuccess : 2,
    complaintSuccessEdit : 2,
    commentSuccess : 2,
    comments:[] 
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
    case 'FETCH_USER_COMPLAINTS': {
      return { ...state, loading: true };
    }
    case 'FETCH_USER_COMPLAINTS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }
    case 'FETCH_USER_COMPLAINTS_FULFILLED': {
      var user_complaints = action.payload.data;
      for (let complaint of user_complaints) {
        complaint.comments = [];
        complaint.commentsLoading = false;
      }
      return {
        ...state,
        loading: false,
        user_complaints: user_complaints
      };
    }
    case 'FETCH_ALL_COMPLAINTS': {
      return { ...state, loading: true };
    }
    case 'FETCH_ALL_COMPLAINTS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }
    case 'FETCH_ALL_COMPLAINTS_FULFILLED': {
      var all_complaints = action.payload.data;
      for (let complaint of all_complaints) {
        complaint.comments = [];
        complaint.commentsLoading = false;
      }
      return {
        ...state,
        loading: false,
        all_complaints: all_complaints
      };
    }
    case 'FETCH_COMMENTS': {
      return { ...state, loading: true,commentSuccess:2 };
    }
    case 'FETCH_COMMENTS_FULFILLED': {
      console.log(action.payload);
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

    case 'FETCH_USER_COMMENTS': {
      return { ...state, loading: true,commentSuccess:2 };
    }
    case 'FETCH_USER_COMMENTS_FULFILLED': {
      console.log(action.payload);
      return {
        ...state,
        loading: false,
        user_complaints: state.user_complaints.map((item, index) => {
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
    case 'FETCH_USER_COMMENTS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }

    case 'FETCH_ADMIN_COMMENTS': {
      return { ...state, loading: true,commentSuccess:2 };
    }
    case 'FETCH_ADMIN_COMMENTS_FULFILLED': {
      console.log(action.payload);
      return {
        ...state,
        loading: false,
        all_complaints: state.all_complaints.map((item, index) => {
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
    case 'FETCH_ADMIN_COMMENTS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }

    case 'POST_COMMMENT': {
      return {...state,loading: true, commentSuccess:2};
    }
    case 'POST_COMMENT_FULFILLED' :{
      return {...state,loading: false,commentSuccess:1};
    }
    case 'POST_COMMENT_REJECTED' :{
     return { ...state, loading: false, error: action.payload,commentSuccess:0 }; 
    }
    case 'FETCH_ALL_STATUS': {
      return { ...state, loading: true };
    }
    case 'FETCH_ALL_STATUS_FULFILLED': {
      var statuses = action.payload.data;
      return {
        ...state,
        loading: false,
        statuses: statuses
      };
    }

    case 'CHANGE_COMPLAINT_STATUS': {
      return { ...state, loading: true };
    }

    case 'CHANGE_COMPLAINT_STATUS_FULFILLED': {
      return { ...state, loading: false };
    }
    case 'CHANGE_COMPLAINT_STATUS_REJECTED': {
      return { ...state, loading: false, error: action.payload };
    }
    case 'POST_COMPLAINT':{
      return {...state,loading:true,complaintSuccess:2};
    }
    case 'POST_COMPLAINT_FULFILLED':{
      return {...state,loading:false,complaintSuccess:1};
    }
    case 'POST_COMPLAINT_REJECTED':{
      return {...state,loading:false,complaintSuccess:0};
    }
    case 'UPDATE_COMPLAINT':{
      return {...state,loading:true,complaintSuccessEdit:2};
    }
    case 'UPDATE_COMPLAINT_FULFILLED':{
      return {...state,loading:false,complaintSuccessEdit:1};
    }
    case 'UPDATE_COMPLAINT_REJECTED':{
      return {...state,loading:false,complaintSuccessEdit:0};
    }
    case 'TOGGLE_PUBLIC_VISIBILTY':{
      return {...state,loading:true,publicToggle:false};
    }
    case 'TOGGLE_PUBLIC_VISIBILTY_SUCCESSFUL':{
      return {...state,loading:false,publicToggle:true};
    }
    case 'TOGGLE_PUBLIC_VISIBILTY_REJECTED':{
      return {...state,loading:false,publicToggle:false};
    }    

    default:
      return state;
  }
}
