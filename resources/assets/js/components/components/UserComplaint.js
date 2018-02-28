import React from 'react';
import { connect } from 'react-redux';

import { Card, CardHeader, CardText, CardTitle } from 'material-ui/Card';
import { List } from 'material-ui/List';
import Divider from 'material-ui/Divider';
import FontIcon from 'material-ui/FontIcon';
import TextField from 'material-ui/TextField';

import { fetchComments } from '../actions/commonActions';

import Comment from './Comment';
import axios from 'axios';

const styleForDiv = {
  display: 'inline-block',
  padding: '20px'
};
class UserComplaint extends React.Component {
  constructor(props) {
    super(props);
    this.handleClick = this.handleClick.bind(this);
    this.complaint = this.props.data;
    this.state = { open: false };
  }

  handleClick(isExpanded) {
    if (isExpanded) this.props.dispatch(fetchComments(this.complaint.id));
  }
  handleSubmitComment() {
    console.log(this.refs.newComment.getValue());
    console.log(this.complaint.id);
    
    axios
        .post('https://localhost/api/v1/comments/',{
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

     
     console.log(this);

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
  componentWillReceiveProps() {
    this.complaint = this.props.data;
  }
  render() {
    this.complaint = this.props.data;
    const complaint = this.complaint;
    if (!complaint) {
      return <div>Loading..</div>;
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
        <Divider/>
        <CardText expandable={true}>
          <div>
            <div>
              <p>{complaint.description}</p>
            </div>
            <List>{mappedComments}</List>
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
export default connect()(UserComplaint);
