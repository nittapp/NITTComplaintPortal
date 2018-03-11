import React from 'react';
import {
  Button,
  Col,
  Form,
  FormGroup,
  ControlLabel,
  FormControl
} from 'react-bootstrap';
import { postComplaint } from '../actions/userActions';
import { connect } from 'react-redux';
class ComplaintForm extends React.Component {
  constructor(props, context) {
    super(props, context);

    this.handleChangeTitle = this.handleChangeTitle.bind(this);
    this.handleChangeDescription = this.handleChangeDescription.bind(this);
    this.state = {
      description: '',
      title: '',
      image: ''
    };
    this.onSubmit = this.onSubmit.bind(this);
  }


  onSubmit(e) {
    e.preventDefault();
    //TODO : Check image upload
    this.props.dispatch(
      postComplaint(this.state.title, this.state.description, this.state.image)
    );
  }

  handleChangeTitle(e) {
    this.setState({ title: e.target.value });
  }
  handleChangeDescription(e) {
    this.setState({ description: e.target.value });
  }
  handleChangeImage(e) {
    this.setState({ image: e.target.files[0] });
  }
  render() {
    if(this.props.complaintSuccess===1){
      alert("Complaint submitted successfully");
    }
    else if(this.props.complaintSuccess===0){
      alert("Check your internet connection");
    }
    return (
      <Col xs={8} xsOffset={2} style={{ paddingTop: '3%' }}>
        <Form onSubmit={this.onSubmit} >
          <FormGroup controlId="formBasicText">
            <ControlLabel>Title</ControlLabel>
            <FormControl
              type="text"
              value={this.state.title}
              placeholder="Enter title"
              onChange={this.handleChangeTitle}
            />
          </FormGroup>
          <FormGroup controlId="formControlsTextarea">
            <ControlLabel>Complaint Description</ControlLabel>
            <FormControl
              componentClass="textarea"
              value={this.state.description}
              placeholder="Enter the complaint description"
              onChange={this.handleChangeDescription}
            />
          </FormGroup>
          <ControlLabel>Choose image</ControlLabel>
          <FormControl
            type="file"
            placeholder="Choose image"
            onChange={(e)=>this.handleChangeImage(e)}
            style={{ paddingBottom: '5%' }}
          />
          <Button type="submit" bsStyle="primary">
            Submit
          </Button>
        </Form>
      </Col>
    );
  }
}
function mapStateToProps(state) {
  return {
    complaintSuccess: state.complaints.complaintSuccess
  };
}
export default connect(mapStateToProps)(ComplaintForm);
