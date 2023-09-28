import React from 'react';
import {Link, Route, Router} from 'wouter';
import Semesterlist from "../components/SemesterList";
function App() {
    return (
        <div className="app">
            <nav>
                <div>React menu</div>
                <ul>
                    <li><Link href={'/react/semesters'}>Semestres</Link></li>
                </ul>
            </nav>
            <Router>
                <Route path="/react/semesters">
                    <Semesterlist/>
                </Route>
            </Router>
        </div>
    );
}

export default App;
