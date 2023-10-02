import React, {useState, useEffect} from 'react';
import {getSemester} from '../services/api';
import {useRoute} from 'wouter';

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);
        });
    }, [params.id]);

    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div>
                    <h1>{semester.name}</h1>
                    <p>Start Date: {semester.startDate}</p>
                    <p>End Date: {semester.endDate}</p>
                </div>
            )}
        </div>
    );
}

export default Semester;
