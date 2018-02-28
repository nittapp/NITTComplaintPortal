import React from 'react';

import { lightBlack } from 'material-ui/styles/colors';

export default class ComplaintStatus extends React.Component {
  render() {
    const status = this.props.data;
    return (
      <div>
        <div>
          <span style={{ color: lightBlack }}>Status:</span>
        </div>
        <div style={{ paddingLeft: '5px', paddingRight: '5px' }}>
          <p>
            {status.name}
            <br />
            {status.message}
          </p>
        </div>
      </div>
    );
  }
}
