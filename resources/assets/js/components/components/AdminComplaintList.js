import React from 'react';

import { List, ListItem } from 'material-ui/List';
import Complaint from './AdminComplaint';

export default class AdminComplaintList extends React.Component {
  render() {
    const complaints = this.props.data;
    const statuses = this.props.statuses;
    const mappedComplaints = complaints.map((complaint, i, arr) => (
      <ListItem key={complaint.id}>
        <Complaint data={complaint} statuses={statuses} />
      </ListItem>
    ));
    return (
      <div>
        <List>{mappedComplaints}</List>
      </div>
    );
  }
}

