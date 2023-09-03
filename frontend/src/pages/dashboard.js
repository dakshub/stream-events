import AppLayout from '@/components/Layouts/AppLayout'
import axios from '@/lib/axios'
import { useState, useEffect } from 'react'

const Dashboard = () => {
    const [pageHeight, setPageHeight] = useState(0)
    const [events, setEvents] = useState([])
    const [endOfResults, setEndOfResults] = useState(false)
    const [isLoading, setIsLoading] = useState(false)
    const [error, setError] = useState(null)
    const [page, setPage] = useState(1)
    const [isSelected, setIsSelected] = useState(false)

    const fetchEvents = async () => {
        setIsLoading(true)
        setError(null)

        try {
            const response = await axios.get(`/api/events?page=${page}`)
            if (response.data.data.length === 0) {
                setEndOfResults(true)
                return
            }
            setEvents(prevEvents => [...prevEvents, ...response.data.data])
            setPage(prevPage => prevPage + 1)
        } catch (error) {
            setError(error)
        } finally {
            setIsLoading(false)
        }
    }

    const handleScroll = () => {
        if (
            window.innerHeight + document.documentElement.scrollTop !==
                document.documentElement.offsetHeight ||
            isLoading
        ) {
            return
        }
        setPageHeight(document.documentElement.offsetHeight)

        if (!endOfResults) {
            fetchEvents()
        }
    }

    useEffect(() => {
        if (events.length === 0) {
            fetchEvents()
        }
        window.scrollTo(0, pageHeight)
        window.addEventListener('scroll', handleScroll)

        return () => window.removeEventListener('scroll', handleScroll)
    }, [isLoading])

    if (isLoading) return <div>'Loading...'</div>
    if (error) return <div>'An error has occurred: {error.message}'</div>

    return (
        <AppLayout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Stream Events
                </h2>
            }>
            <div className="py-6">
                {events.map((event, index) => (
                    <div
                        className="max-w-4xl mx-auto sm:px-6 lg:px-8"
                        key={index}>
                        <div className="flex items-center justify-between border-b border-gray-200 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            {event.type === 'Follower' ? (
                                <div className="p-3">
                                    {event.eventable.name} followed you!
                                </div>
                            ) : (
                                <></>
                            )}
                            {event.type === 'Subscriber' ? (
                                <div className="p-3">
                                    {event.eventable.name} (Tier{' '}
                                    {event.eventable.subscription_tier})
                                    subscribed to you!
                                </div>
                            ) : (
                                <></>
                            )}
                            {event.type === 'Donation' ? (
                                <div className="p-3">
                                    {event.eventable.donator_name} donated{' '}
                                    {event.eventable.amount}{' '}
                                    {event.eventable.currency} to you! ( "
                                    {event.eventable.donation_message}")
                                </div>
                            ) : (
                                <></>
                            )}
                            {event.type === 'MerchSale' ? (
                                <div className="p-3">
                                    {event.eventable.buyer_name} bought{' '}
                                    {event.eventable.quantity}{' '}
                                    {event.eventable.item}(s) from you for{' '}
                                    {event.eventable.total}{' '}
                                    {event.eventable.currency}!
                                </div>
                            ) : (
                                <></>
                            )}
                            <div className="p-3">
                                <input type="checkbox" />
                            </div>
                        </div>
                    </div>
                ))}
            </div>
            {endOfResults ? (
                <div className="py-6 text-center">
                    Reached the end of events!
                </div>
            ) : (
                <></>
            )}
        </AppLayout>
    )
}

export default Dashboard
