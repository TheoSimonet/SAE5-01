import React, {useState, useEffect} from 'react';
import {fetchSemesters, fetchUsers} from '../services/api';
import {Link} from 'wouter';

function Semesterlist() {
    const [semesters, setSemesters] = useState(null);

    useEffect(() => {
        fetchSemesters().then((data) => {
            setSemesters(data["hydra:member"]);
        });
    }, []);

    return (
        <div>
            {semesters ===null ? 'Loading...' : semesters.map((semester) => (<div key={semester.id}><Link href={`/react/semesters/${semester.id}`}>{semester.name}</Link></div>))}
        </div>
    );
}

export default Semesterlist;
