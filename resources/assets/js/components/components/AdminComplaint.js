import React from 'react';
import { connect } from 'react-redux';

import Divider from 'material-ui/Divider';
import {
  Button,
  Card,
  CardBody,
  CardImage,
  CardTitle,
  CardText
} from 'mdbreact';
import { fetchComments } from '../actions/adminActions';
//import { postComment } from '../actions/userActions' ;
import '../index.css';
import Modal from './AdminModal.js';
import Editmodal from './AdminEditModal.js';

class UserComplaint extends React.Component {
  constructor(props) {
    super(props);
    this.handleClick = this.handleClick.bind(this);
    this.closeModal = this.closeModal.bind(this);
    this.closeModalForEdit = this.closeModalForEdit.bind(this);
    this.handleClickForEdit = this.handleClickForEdit.bind(this);
    this.handledeletecomplaint = this.handledeletecomplaint.bind(this);
    this.complaint = this.props.data;
    this.state = { open: false, openModal: false, openModalForEdit: false };
  }

  handleClick() {
    this.props.dispatch(fetchComments(this.complaint.id));
    this.setState({ openModal: true });
  }
  handledeletecomplaint() {
    //TODO to give request to backend to delete the existing complaint;
  }
  closeModal() {
    this.setState({ openModal: false });
  }
  handleClickForEdit() {
    this.setState({ openModalForEdit: true });
  }
  closeModalForEdit() {
    this.setState({ openModalForEdit: false });
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
            <Button
              onClick={this.handleClick}
              color="info"
              style={{ margin: '1%' }}
            >
              Show Details
            </Button>
            <Button
              onClick={this.handleClickForEdit}
              color="warning"
              style={{ margin: '1%' }}
            >
              Edit Complaint
            </Button>
            <Button
              onClick={this.handledeletecomplaint}
              color="danger"
              style={{ margin: '1%' }}
            >
              Delete Complaint
            </Button>
            <Modal
              showmodal={this.state.openModal}
              closemodal={this.closeModal}
              complaint={this.complaint}
            />
            <Editmodal
              showmodal={this.state.openModalForEdit}
              closemodal={this.closeModalForEdit}
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
