import React from 'react';
import { connect } from 'react-redux';

import {
  Button,
  Card,
  CardBody,
  CardImage,
  CardTitle,
  CardText
} from 'mdbreact';

import Divider from 'material-ui/Divider';

//fetch public comments based on new action
import { fetchComments } from '../actions/commonActions';

import '../index.css';
import Modal from './PublicModal.js';
class UserComplaint extends React.Component {
  constructor(props) {
    super(props);
    this.handleClick = this.handleClick.bind(this);
    this.complaint = this.props.data;
    this.closeModal = this.closeModal.bind(this);
    this.state = { open: false, openModal: false };
  }

  handleClick() {
    //fetch public comments
    this.props.dispatch(fetchComments(this.complaint.id));
    this.setState({ openModal: true });
  }
  closeModal() {
    this.setState({
      openModal: false
    });
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

    return (
      <div className="complaintCard">
        <Card>
          <CardImage
            className="img-fluid image"
             src={"/images/"+complaint.image_path}
          />
          <CardBody>
            <CardTitle>{complaint.title}</CardTitle>
            <CardText>
              {complaint.status.name} || {complaint.status.message}
            </CardText>
            <Button onClick={this.handleClick} color="info">
              Show Details
            </Button>
            <Modal
              showmodal={this.state.openModal}
              closemodal={this.closeModal}
              complaint={this.complaint}
            />
          </CardBody>
        </Card>
        <br />
        <Divider />
      </div>
    );
  }
}
export default connect()(UserComplaint);
