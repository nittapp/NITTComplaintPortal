import React from 'react';

import { List, ListItem } from 'material-ui/List';

import Complaint from './UserComplaint';

export default class UserComplaintList extends React.Component {
  render() {
    const complaints = this.props.data;
    if (complaints.length === 0) {
      return <div>No complaints made</div>;
    }
    const mappedComplaints = complaints.map((complaint, i, arr) => (
      <ListItem key={complaint.id}>
        <Complaint data={complaint} />
      </ListItem>
    ));
    return (
      <div>
        <List>{mappedComplaints}</List>
      </div>
    );
  }
}
