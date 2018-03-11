import React, { Component } from 'react';
import { Switch, Route } from 'react-router-dom';
import { ListItem } from 'material-ui';
import AdminDashboard from './AdminDashboard';
import UserDashboard from './UserDashboard';
import axios from 'axios';

axios.defaults.headers.common['X_NITT_APP_USERNAME'] = '5';
axios.defaults.headers.common['X_NITT_APP_NAME'] = 'mess';
axios.defaults.headers.common['X_NITT_APP_IS_ADMIN'] = 'true';

class App extends Component {
  componentDidMount() {
    ListItem.defaultProps.disableTouchRipple = true;
    ListItem.defaultProps.disableFocusRipple = true;
  }
  render() {
    return (
      <Switch>
        <Route exact path="/" component={UserDashboard} />
        <Route path="/admin" component={AdminDashboard} />
      </Switch>
    );
  }
}

export default App;
