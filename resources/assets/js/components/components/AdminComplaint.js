import React from 'react';
import { connect } from 'react-redux';
import { Card, CardHeader, CardText, CardTitle } from 'material-ui/Card';
import { DropdownButton, MenuItem } from 'react-bootstrap' ;

import { List } from 'material-ui/List';
import Divider from 'material-ui/Divider';
import FontIcon from 'material-ui/FontIcon';
import TextField from 'material-ui/TextField';
import { fetchComments } from '../actions/commonActions';
import { changeComplaintStatus } from '../actions/adminActions';
import Comment from './Comment';
import {axios} from 'axios' ;

const styleForDiv = {
  display: 'inline-block',
  padding: '20px'
};



class AdminComplaint extends React.Component {
  

  constructor(props) {
    super(props);
    this.handleClick = this.handleClick.bind(this);
    
    
    this.handleSelectStatus = this.handleSelectStatus.bind(this);
    
    this.setup();
    this.state = { open: false , btnTitle: "Change Status" };
  }

  handleClick(isExpanded) {
    if (isExpanded) this.props.dispatch(fetchComments(this.complaint.id));
  }
  handleSelectStatus(status){
    this.setState({btnTitle: status.name});
    console.log(this.complaint.id,status.id);
    this.props.dispatch(changeComplaintStatus(this.complaint.id,status.id));
    
  }
  handleSubmitComment() {
    console.log(this.refs.newComment.getValue());
    console.log(this.complaint.id);
    axios
        .post('/api/v1/comments/',{
          complaint_id : this.complaint.id,
          comment : this.refs.newComment.getValue()
        })
        .then(response => {
          console.log(response.data);
          this.props.dispatch(fetchComments(this.complaint.id)); 
        })
        .catch(err => {
          console.log(err.data);
        });


    var addCommentdata = this.refs.newComment.getValue();
    var addCommentId = 'someOne';
    var addComment = {
      id: 12,
      complaint_id: this.complaint.id,
      user_id: addCommentId,
      comment: addCommentdata
    };
    if (addComment.comment !== '') this.complaint.comments.push(addComment);
    this.setState({ open: !this.state.open });
  }

  setup(){
    this.complaint = this.props.data;
    this.statuses=this.props.statuses;
  }

  componentWillReceiveProps() {
    this.setup();
  }
  componentWillMount(){
    this.setup();
  }

  render() {
    const complaint = this.complaint;
    const statuses = this.statuses;
    if(!complaint || statuses.length ===0){
      return null;
    }
    
    
    const mappedComments = complaint.comments.map((comment, i, arr) => (
      <Comment key={comment.id} data={comment} />
    ));
    
   
    return (
      <Card onExpandChange={isExpanded => this.handleClick(isExpanded)}>
        <CardHeader
          
          
          actAsExpander={true}
          showExpandableButton={true}
        />
        <CardTitle title={<p>{complaint.title}</p>}
          subtitle={
            <div>
              <p>{complaint.created_at}</p>
              <p>
                {complaint.status.name} || {complaint.status.message}
              </p>
            </div>
          }
          />
        <Divider />

        <CardText  expandable={true}>
          <div>
            <div>
              <p>{complaint.description}</p>
            </div>
            <br />
            <DropdownButton
                bsStyle={'primary'}
                title={this.state.btnTitle}
                id={'dropdown-basic-1'}
                >
                {statuses.map(status=> <MenuItem key={status.id} onSelect={()=> this.handleSelectStatus(status)}>{status.name}</MenuItem>)}
            </DropdownButton>
            <br /> 
            <List ref="commentAdd">{mappedComments}</List>
            <div>
              <TextField hintText="Add Comment" ref="newComment" />
              <div
                onClick={this.handleSubmitComment.bind(this)}
                style={styleForDiv}
              >
                <FontIcon className="material-icons">send</FontIcon>
              </div>
            </div>
          </div>
        </CardText>
      </Card> 
    

    );
  }
}

export default connect()(AdminComplaint);

