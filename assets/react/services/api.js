export const BASE_URL = '/api';

export function fetchSemesters() {
    return fetch(`${BASE_URL}/semesters`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}

export function getSemester(id) {
    return fetch(`${BASE_URL}/semesters/${id}`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}
export function fetchGroups() {
    return fetch(`${BASE_URL}/groups`)
        .then((response) => (response.ok ? response.json() : Promise.resolve(null)));
}

export function getGroup(id) {
    return fetch(`${BASE_URL}/groups/${id}`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}


export function getMe()
{
    return fetch(`${BASE_URL}/me`, {credentials: "include"}).then((response) => {
        if (response.ok) {
            return response.json();
        } else if (response.status === 401) {
            return Promise.resolve(null);
        }});
}

export function fetchWishes() {
    return fetch(`${BASE_URL}/wishes`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}

export function getWish(id) {
    return fetch(`${BASE_URL}/wishes/${id}`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}

export function getSubject(id) {
    return fetch(`${BASE_URL}/subjects/${id}`).then((response) =>
        response.ok ? response.json() : Promise.resolve(null),
    );
}

