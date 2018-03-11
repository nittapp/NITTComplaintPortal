import React from 'react';
import { Modal, Button } from 'react-bootstrap';
import { List } from 'material-ui/List';
import TextField from 'material-ui/TextField';
import FontIcon from 'material-ui/FontIcon';
import { CardImage } from 'mdbreact';
import Comment from './Comment';
import { fetchComments } from '../actions/commonActions';
import { postComment } from '../actions/adminActions';
import { connect } from 'react-redux';
import '../index.css';
class AdminModal extends React.Component {
  constructor(props) {
    super(props);
    //this.handleclickbutton = this.handleclickbutton.bind(this);
    this.handleSubmitComment = this.handleSubmitComment.bind(this);
    this.handleCommentChange = this.handleCommentChange.bind(this);
    this.handleKeyPress = this.handleKeyPress.bind(this);
    this.state = {
      newcomment: ''
    };
  }
  componentWillMount() {
    window.addEventListener('keypress', this.handleKeyPress);
  }

  handleKeyPress(e) {
    if (e.charCode === 13) {
      this.handleSubmitComment();
    }
  }
  handleCommentChange(e) {
    this.setState({ newcomment: e.target.value });
  }
  handleSubmitComment() {
    this.props.dispatch(
      postComment(this.props.complaint.id, this.state.newcomment)
    );

    if (this.props.commentSuccess) {
      this.props.dispatch(fetchComments(this.props.complaint.id));
    }

    var addCommentdata = this.state.newcomment;
    var addCommentId = getCookie('username');
    var addComment = {
      id: 12,
      complaint_id: this.props.complaint.id,
      user_id: addCommentId,
      comment: addCommentdata
    };
    if (addComment.comment !== '')
      this.props.complaint.comments.push(addComment);
    this.setState({ newcomment: '' });
  }
  render() {
    console.log(this.props.complaint.comments);
    const mappedComments = this.props.complaint.comments.map(
      (comment, i, arr) => <Comment key={comment.id} data={comment} />
    );
    return (
      <Modal show={this.props.showmodal} onHide={this.props.closemodal}>
        <Modal.Header closeButton>
          <Modal.Title>{this.props.complaint.title}</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <br />
          {/* TODO - change the src of the picture for each complaint based on complaint */}
          object.
          <CardImage
            className="img-fluid Modalimage"
             src={"/images/"+this.props.complaint.image_path}
          />
          <br />
          <p>{this.props.complaint.description}</p>
          <br />
          <List>{mappedComments}</List>
          <TextField
            hintText="Add Comment"
            onChange={this.handleCommentChange}
            value={this.state.newcomment}
          />
          <div className="Modalbutton" onClick={this.handleSubmitComment}>
            <FontIcon className="material-icons">send</FontIcon>
          </div>
        </Modal.Body>
        <Modal.Footer>
          <Button onClick={this.props.closemodal}>Close</Button>
        </Modal.Footer>
      </Modal>
    );
  }
}

function mapStateToProps(state) {
  return {
    commentSuccess: state.complaints.commentSuccess
  };
}
export default connect(mapStateToProps)(AdminModal);
