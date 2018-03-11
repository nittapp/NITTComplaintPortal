import React from 'react';
import { connect } from 'react-redux';

import { Tabs, Tab, PageHeader } from 'react-bootstrap';

import UserComplaintList from './UserComplaintList';
import PublicComplaintList from './PublicComplaintList';
import ComplaintForm from './ComplaintForm';
import { fetchPublicComplaints } from '../actions/commonActions';
import { fetchUserComplaints } from '../actions/userActions';

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
    this.props.dispatch(fetchUserComplaints());
  }

  render() {
    const publicComplaints = this.props.publicComplaints;
    const userComplaints = this.props.userComplaints;
    return (
      <div>
        <PageHeader style={{textAlign:'center'}}>
          Complaints Portal
        </PageHeader>
        <div>
          <Tabs
            onChange={this.handleChange}
            value={this.state.slideIndex}
            id="myTab"
          >
            <Tab title="Public Complaints" eventKey={0} >
              <div >
                <PublicComplaintList data={publicComplaints} />
              </div>
            </Tab>
            <Tab title="My Complaints" eventKey={1} >
              <div >
                <UserComplaintList data={userComplaints} />
              </div>
            </Tab>
            <Tab title="Create Complaint" eventKey={2} >
              <div >
                <ComplaintForm />
              </div>
            </Tab>
          </Tabs>
        </div>
      </div>
    );
  }
}

function mapStateToProps(state) {
  return {
    publicComplaints: state.complaints.complaints,
    userComplaints: state.complaints.user_complaints
    
  };
}

export default connect(mapStateToProps)(UserDashboard);
