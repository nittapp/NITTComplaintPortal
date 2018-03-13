import React from 'react';
import { Modal } from 'react-bootstrap';
import { Button, Col, Row } from 'react-bootstrap';
import { Form, FormGroup, ControlLabel, FormControl } from 'react-bootstrap';
import { connect } from 'react-redux';
import Toggle from 'material-ui/Toggle';
import { updateComplaint } from '../actions/userActions';
import { toggleComplaintView, changeComplaintStatus } from '../actions/adminActions';
import DropDownMenu from 'material-ui/DropDownMenu';
import MenuItem from 'material-ui/MenuItem';
class AdminEditModal extends React.Component {
  constructor(props, context) {
    super(props);
    this.handlechangeTitle = this.handlechangeTitle.bind(this);
    this.handledescription = this.handledescription.bind(this);

    this.handleChangeImage = this.handleChangeImage.bind(this);
    this.makeComplaintPublic = this.makeComplaintPublic.bind(this);
    this.handleDropDown = this.handleDropDown.bind(this);
    this.state = {
      title: this.props.complaint.title,
      description: this.props.complaint.description,
      // TODO - the state for image will be whatever the complaint object has based on backend
      image: '',
      //publicToggleStatus: (this.props.complaint.is_public)? "Hide":"Make public"
      publicToggleStatus: this.props.complaint.is_public,
      status_id: this.props.complaint.status_id
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
  makeComplaintPublic() {
    this.props.dispatch(toggleComplaintView(this.props.complaint.id));
    if (this.props.publicToggle)
      this.setState({ publicToggleStatus: !this.props.publicToggle });
  }
  onSubmit() {
    //TODO add backend to edit complaint by admin.
    this.props.dispatch(
      updateComplaint(
        this.props.complaint.id,
        this.state.title,
        this.state.description,
        this.state.image
      )
    );
  }
  
  handleDropDown(e, index, value) {
    //some one fix this 
    this.setState({status_id: value+1});
    this.props.dispatch(
          changeComplaintStatus(
        this.props.complaint.id,
        this.state.status_id-1
      )
    );    
  }

  render() {
    // if(this.props.complaintSuccessEdit===1){
    //     alert("Complaint edited successfully");
    //     }
    // else if(this.props.complaintSuccessEdit===0){
    //     alert("Check your internet connection");
    //     }

    // if(this.props.publicToggle){
    //     alert("Complaint made public successfully");
    // }
    // else{
    //     alert("Check your internet connection");
    // }
    const mappedStatuses = this.props.statuses.map((status, i, arr) => (
      <MenuItem value={i} key={i} primaryText={status.name} />
    ));
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
            <Toggle
              label="Make Complaint Public"
              labelPosition="right"
              defaultToggled={this.state.publicToggleStatus}
              onClick={this.makeComplaintPublic}
            />
            <br/><b>Change Status</b><br/>
          <DropDownMenu value={this.state.status_id-1} onChange={this.handleDropDown}>
            {mappedStatuses}
          </DropDownMenu>
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
                onChange={e => this.handleChangeImage(e)}
              />
              <br />
              <Button type="submit" bsStyle="primary">
                Submit
              </Button>
            </Form>
            <br />
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
    complaintSuccessEdit: state.complaints.complaintSuccess,
    publicToggle: state.complaints.publicToggle
  };
}
export default connect(mapStateToProps)(AdminEditModal);
