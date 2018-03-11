import React from 'react';
import { connect } from 'react-redux';

import ComplaintList from './AdminComplaintList';
import { fetchAllComplaints } from '../actions/adminActions';

import { fetchAllComplaintStatus } from '../actions/adminActions';
import { PageHeader } from 'react-bootstrap';

class AdminDashboard extends React.Component {
  componentWillMount() {
    this.props.dispatch(fetchAllComplaints());
    //REMOVE BELOW COMMENT WHEN ADMIN ACTIONS ARE CHANGED TO 8080
    this.props.dispatch(fetchAllComplaintStatus());
  }

  render() {
    const complaints = this.props.complaints;
    console.log(complaints);
    //REMOVE BELOW COMMENT WHEN ADMIN ACTIONS ARE CHANGED TO 8080
    //const statuses = this.props.statuses;
    const statuses = [{ id: 1, name: 'private' }, { id: 2, name: 'public' }];

    console.log(statuses);
    return (
      <div>
        <PageHeader style={{ textAlign: 'center' }}>
          Complaints Portal <small>Admin Console</small>
        </PageHeader>
        <div>
          <ComplaintList data={complaints} statuses={statuses} />
        </div>
      </div>
    );
  }
}

function mapStateToProps(state) {
  return {
    complaints: state.complaints.all_complaints,
    statuses: state.complaints.statuses
  };
}

export default connect(mapStateToProps)(AdminDashboard);
