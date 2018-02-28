import React from 'react';
import { connect } from 'react-redux';

import ComplaintList from './AdminComplaintList';
import { fetchPublicComplaints } from '../actions/commonActions';

import { fetchAllComplaintStatus } from '../actions/adminActions';

class AdminDashboard extends React.Component {
  componentWillMount() {
    this.props.dispatch(fetchPublicComplaints());
    this.props.dispatch(fetchAllComplaintStatus());
  }

  render() {
    const complaints = this.props.complaints;
    const statuses = this.props.statuses;
    console.log(statuses);
    return (
      <div >
        <ComplaintList data={complaints} statuses={statuses} />
      </div>
    );
  }
}

function mapStateToProps(state) {
  return {
    complaints: state.complaints.complaints,
    statuses: state.complaints.statuses
  };
}

export default connect(mapStateToProps)(AdminDashboard);
