import React, { useState, useEffect } from 'react';
import { getSemester, getMe, getSubjectTag } from '../services/api';
import { useRoute } from 'wouter';
import WishForm from './WishForm';
import "../../styles/semesterDetail.css"

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');
    const [userData, setUserData] = useState(null);
    const [tagsData, setTagsData] = useState([]);

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);
        });
        getMe().then((userData) => {
            setUserData(userData);
        });
    }, [params.id]);

    useEffect(() => {
        if (semester) {
            const tagUrls = semester.subjects.reduce((urls, subject) => {
                subject.tags.forEach((tagUrl) => {
                    if (typeof tagUrl === "string" && !urls.includes(tagUrl)) {
                        urls.push(tagUrl);
                    }
                });
                return urls;
            }, []);

            const tagPromises = tagUrls.map(tagUrl => {
                const cachedTag = tagsData.find(tag => tag['@id'] === tagUrl);
                if (cachedTag) {
                    return Promise.resolve(cachedTag);
                } else {
                    return getSubjectTag(tagUrl);
                }
            });

            Promise.all(tagPromises).then((tags) => {
                const tagMap = new Map();

                tags.forEach(tag => {
                    tagMap.set(tag['@id'], tag);
                    if (!tagsData.some(existingTag => existingTag['@id'] === tag['@id'])) {
                        setTagsData(prevTagsData => [...prevTagsData, tag]);
                    }
                });

                const updatedSubjects = semester.subjects.map((subject) => {
                    subject.tags = subject.tags.map((tagUrl) => {
                        if (typeof tagUrl === "string" && tagMap.has(tagUrl)) {
                            return tagMap.get(tagUrl);
                        }
                        return tagUrl;
                    });
                    return subject;
                });

                setSemester({
                    ...semester,
                    subjects: updatedSubjects,
                });
            });
        }
    }, [semester, tagsData]);


    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div className={"subjectList"}>
                    <ul>
                        {semester.subjects.map((subject) => {
                            const subjectId = subject['@id'].split('/').pop();
                            return (
                                <li key={subjectId} className="semester-li">
                                    <h2 className={"subjectName"}>{subject.subjectCode + ' - ' + subject.name }</h2>

                                    <div className="subjectTags">
                                        {subject.tags.map((tag, index) => (
                                            <span key={index} className="tag">
                                                {tag.name}
                                            </span>
                                        ))}
                                    </div>

                                    <br /><br />
                                    {(userData && userData.roles && userData.roles.includes("ROLE_ADMIN")) ? (
                                        <div>
                                            <p className="groupe">Groupes |</p>
                                            <div className="Postuler-container">
                                                <WishForm subjectId={`/api/subjects/${subjectId}`} />
                                            </div>
                                        </div>
                                    ) : null}
                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default Semester;
