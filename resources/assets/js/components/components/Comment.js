import React from 'react';
import { ListItem } from 'material-ui/List';
import Divider from 'material-ui/Divider';

export default class Comment extends React.Component {
  render() {
    const comment = this.props.data;
    if (!comment) {
      return <div>Loading..</div>;
    }
    return (
      <div>
        <ListItem
          primaryText={comment.user_id}
          secondaryText={<p>{comment.comment}</p>}
          secondaryTextLines={2}
        />
        <Divider />
      </div>
    );
  }
}
