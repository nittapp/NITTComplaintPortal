import React from 'react';
import { Button } from 'react-bootstrap';
import { Form, FormGroup,ControlLabel,FormControl } from 'react-bootstrap';
import axios from 'axios';
export default class ComplaintForm extends React.Component {
  constructor(props, context) {
    super(props, context);

    this.handleChangeTitle = this.handleChangeTitle.bind(this);
    this.handleChangeDescription = this.handleChangeDescription.bind(this);
    this.state = {
      description: '',
      title: ''
    };
    this.onSubmit=this.onSubmit.bind(this);
  }

  onSubmit(e){
    e.preventDefault();
    
    axios.post('/api/v1/complaints', {
        title: this.state.title,
        description: this.state.description,
        image_url:'nil'
      })
      .then(function (response) {
        console.log(response);
        alert("Form submitted");
      })
      .catch(function (error) {
        console.log(error);
        alert("Check your internet connection");
      });
  }


  handleChangeTitle(e) {
    this.setState({ title: e.target.value });
  }
  handleChangeDescription(e) {
    this.setState({ description: e.target.value });
  }

  render() {
    return (
      <Form onSubmit={this.onSubmit}>
        <FormGroup
          controlId="formBasicText"
        >
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
          <FormControl componentClass="textarea" 
          value={this.state.description}
           placeholder="Enter the complaint description"
           onChange={this.handleChangeDescription} />
        </FormGroup>
        <Button type="submit" bsStyle="primary">Submit</Button>
      </Form>
    );
  }
}

