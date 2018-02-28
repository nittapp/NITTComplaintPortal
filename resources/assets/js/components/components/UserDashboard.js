import React from 'react';
import { connect } from 'react-redux';

import { Tabs, Tab, } from 'react-bootstrap';

import ComplaintList from './UserComplaintList';
import ComplaintForm from './ComplaintForm';
import { fetchPublicComplaints } from '../actions/commonActions';


class UserDashboard extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      slideIndex: 0
    };
  }

  handleChange (e){
    this.setState({
      slideIndex: e.target.value
    });
  };

  componentWillMount() {
    this.props.dispatch(fetchPublicComplaints());
  }

  render() {
    const publicComplaints = this.props.publicComplaints;

    return (
        <Row>
            <Col sm={8} xsOffset={8}>
              <div>
                <Tabs
                  onChange={this.handleChange}
                  value={this.state.slideIndex}
                  id="myTab"
                >
                  <Tab title="Public Complaints" eventKey={0}>
                    <div >
                      <ComplaintList data={publicComplaints}/>
                    </div>
                  </Tab>
                  <Tab title="My Complaints" eventKey={1}>
                    <div >
                      <ComplaintList data={publicComplaints}/>
                    </div>
                  </Tab>
                  <Tab title="Create Complaint" eventKey={2}>
                    <div >
                      <ComplaintForm />
                    </div>
                  </Tab>
                </Tabs>
              </div>
          </Col>
        </Row>
    );
  }
}

function mapStateToProps(state) {
  return {
    publicComplaints: state.complaints.complaints
  };
}

export default connect(mapStateToProps)(UserDashboard);
