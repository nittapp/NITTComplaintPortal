import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter } from 'react-router-dom';
import  {unregister, registerServiceWorker} from './registerServiceWorker';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

import './index.css';
import App from './components/App';
import store from './store';

const root = document.getElementById('root');
ReactDOM.render(
  <BrowserRouter>
    <MuiThemeProvider>
      <Provider store={store}>
        <App />
      </Provider>
    </MuiThemeProvider>
  </BrowserRouter>,
  root
);
//registerServiceWorker();
unregister();