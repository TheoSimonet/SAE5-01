import React from 'react';
import {Link, Route, Router} from 'wouter';
import Semesterlist from "../components/SemesterList";
import Semester from "../components/SemesterDetail";
function App() {
    return (
        <div className="app">
            <nav>
                <ul>
                    <li><Link href={'/react/semesters'}>Semestres</Link></li>
                </ul>
            </nav>
            <Router>
                <Route path="/react/semesters">
                    <Semesterlist/>
                </Route>
                <Route path="/react/semesters/:id">
                    <Semester/>
                </Route>
            </Router>
        </div>
    );
}

export default App;
