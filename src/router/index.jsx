import { lazy } from 'react';
import { Routes, Route } from 'react-router-dom';

const Home = lazy(() => import('../pages/Home'));

export default function Router() {
  return (
    <Routes>
      <Route path='/' element={<Home />} />
    </Routes>
  );
}