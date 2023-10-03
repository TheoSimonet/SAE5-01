import React from 'react';
import {Link, Route, Router} from 'wouter';
import Semesterlist from "../components/SemesterList";
import Grouplist from "../components/GroupList";
import Semester from "../components/SemesterDetail";
import Group from "../components/GroupDetail";

function App() {
    return (
        <div className="app">
            <nav>
                <Semesterlist/>
                <Grouplist/>
            </nav>
            <Router>
                <Route path="/react/semesters/:id">
                    <Semester/>
                </Route>
                <Route path="/react/groups/:id">
                    <Group/>
                </Route>
            </Router>
        </div>
    );
}

export default App;
