import './App.css';
import { Routes, Route } from 'react-router-dom';
import { lazy } from 'react';

const Home = lazy(() => import('./pages/Home'));
const SignIn = lazy(() => import('./pages/SignIn'));
const SignUp = lazy(() => import('./pages/SignUp'));
const Profile = lazy(() => import('./pages/Profile'));
const BuyCells = lazy(() => import('./pages/BuyCells'));
const BuyPeople = lazy(() => import('./pages/BuyPeople'));

function App() {
  return (
    <Routes>
      <Route path='/' element={<Home />} />
      <Route path='/login' element={<SignIn />} />
      <Route path='/registration' element={<SignUp />} />
      <Route path='/profile' element={<Profile />} />
      <Route path='/cells' element={<BuyCells />} />
      <Route path='/people-space' element={<BuyPeople />} />
    </Routes>
  );
}

export default App;
