import { createStore, applyMiddleware } from 'redux';
import { logger } from 'redux-logger';
import thunkMiddleware from 'redux-thunk';
import promise from 'redux-promise-middleware';

import reducer from './reducers';

const middleware = applyMiddleware(promise(), thunkMiddleware, logger);

const store = createStore(reducer, middleware);
export default store;
