import React, { Suspense } from 'react';
import { domAnimation, LazyMotion } from 'framer-motion';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import { BrowserRouter } from 'react-router-dom';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <LazyMotion features={domAnimation} strict>
      <Suspense fallback={<h1 style={{ textAlign: 'center' }}>Loading...</h1>}>
        <BrowserRouter>
          <App />
        </BrowserRouter>
      </Suspense>
    </LazyMotion>
  </React.StrictMode>
);
