import React from 'react';

import { List, ListItem } from 'material-ui/List';

import Complaint from './PublicComplaint';

export default class PublicComplaintList extends React.Component {
  render() {
    const complaints = this.props.data;
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
