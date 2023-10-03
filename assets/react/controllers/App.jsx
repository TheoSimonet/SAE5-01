import React from 'react';
import {Link, Route, Router} from 'wouter';
import Semesterlist from "../components/SemesterList";
import Grouplist from "../components/GroupList";
import Semester from "../components/SemesterDetail";
import  Me from "../components/Me";
import  Repartition from "../components/Repartition";
import Group from "../components/GroupDetail";

function App() {
    return (
        <div className="app">
            <Grouplist/>
            <Router>
                <Route path="/">
                    <Me/>
                </Route>

                <Route path="/">
                    <Repartition/>
                </Route>
                <Route path="/react/semesters">
                    <Semesterlist/>
                </Route>
                <Route path="/react/semesters/:id">
                    <Semesterlist/>
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
