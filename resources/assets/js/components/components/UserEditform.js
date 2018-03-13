import React from 'react';
import { Modal } from 'react-bootstrap';
import { Button, Col } from 'react-bootstrap';
import { Form, FormGroup, ControlLabel, FormControl } from 'react-bootstrap';
import { connect } from 'react-redux';
import {updateComplaint } from '../actions/userActions';
class UserEditForm extends React.Component {
  constructor(props, context) {
    super(props);
    this.handlechangeTitle = this.handlechangeTitle.bind(this);
    this.handledescription = this.handledescription.bind(this);
    this.handleChangeImage = this.handleChangeImage.bind(this);
    this.state = {
      title: this.props.complaint.title,
      description: this.props.complaint.description,
      // TODO the state for image will be whatever the complaint object has based on backend
      image: ''
    };
    this.onSubmit = this.onSubmit.bind(this);
  }
  handlechangeTitle(e) {
    this.setState({ title: e.target.value });
  }
  handledescription(e) {
    this.setState({ description: e.target.value });
  }
  handleChangeImage(e) {
    this.setState({ image: e.target.files[0] });
  }
  onSubmit() {
    this.props.dispatch(
      updateComplaint(this.props.complaint.id,this.state.title, this.state.description, this.state.image)
    );
  }
  render() {
    // if(this.props.complaintSuccessEdit===1){
    //   alert("Complaint edited successfully");
    // }
    // else if(this.props.complaintSuccessEdit===0){
    //   alert("Check your internet connection");
    // }
    return (
      <Modal
        show={this.props.showmodal}
        onHide={this.props.closemodal}
        bsSize="large"
        aria-labelledby="contained-modal-title-lg"
      >
        <Modal.Header closeButton>
          <Modal.Title>Edit Complaint </Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <Form onSubmit={this.onSubmit}>
              <FormGroup controlId="formBasicText">
                <ControlLabel>Title</ControlLabel>
                <FormControl
                  type="text"
                  value={this.state.title}
                  placeholder="Enter title"
                  onChange={this.handlechangeTitle}
                />
              </FormGroup>
              <FormGroup controlId="formControlsTextarea">
                <ControlLabel>Complaint Description</ControlLabel>
                <FormControl
                  componentClass="textarea"
                  value={this.state.description}
                  placeholder="Enter the complaint description"
                  onChange={this.handledescription}
                />
              </FormGroup>
              <ControlLabel>Choose image</ControlLabel>
              <FormControl
                type="file"
                value={this.state.image}
                placeholder="Choose image"
                onChange={(e)=>this.handleChangeImage(e)}
                style={{ paddingBottom: '5%' }}
              />
              <Button type="submit" bsStyle="primary">
                Submit
              </Button>
            </Form>
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
    complaintSuccessEdit: state.complaints.complaintSuccess
  };
}
export default connect(mapStateToProps)(UserEditForm);
