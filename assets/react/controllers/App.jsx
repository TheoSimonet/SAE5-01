import React from 'react';
import {Link, Route, Router} from 'wouter';
import Semesterlist from "../components/SemesterList";
import Semester from "../components/SemesterDetail";
function App() {
    return (
        <div className="app">
            <nav>
                <Semesterlist/>
            </nav>
            <Router>
                <Route path="/react/semesters/:id">
                    <Semester/>
                </Route>
            </Router>
        </div>
    );
}

export default App;
