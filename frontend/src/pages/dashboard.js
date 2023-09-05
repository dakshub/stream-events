import AppLayout from '@/components/Layouts/AppLayout'
import axios from '@/lib/axios'
import { useState, useEffect } from 'react'

const Dashboard = () => {
    const [pageHeight, setPageHeight] = useState(0)
    const [events, setEvents] = useState([])
    const [totalRevenue, setTotalRevenue] = useState(null)
    const [totalFollowersGained, setTotalFollowersGained] = useState(null)
    const [topItemsBySales, setTopItemsBySales] = useState(null)
    const [endOfResults, setEndOfResults] = useState(false)
    const [isLoading, setIsLoading] = useState(false)
    const [error, setError] = useState(null)
    const [page, setPage] = useState(1)

    const fetchEvents = async () => {
        setIsLoading(true)
        setError(null)

        try {
            const response = await axios.get(`/api/events?page=${page}`)
            if (response.data.data.length === 0) {
                setEvents(events)
                setEndOfResults(true)
            }
            setEvents(prevEvents => [...prevEvents, ...response.data.data])
            setPage(prevPage => prevPage + 1)
        } catch (error) {
            setError(error)
        } finally {
            setIsLoading(false)
        }
    }

    const fetchAnalytics = async () => {
        setError(null)
        setIsLoading(true)

        try {
            const totalRevenueResponse = await axios.get(
                '/api/analytics/total-revenue',
            )
            const totalFollowersGainedResponse = await axios.get(
                '/api/analytics/total-followers-gained',
            )
            const topItemsBySalesResponse = await axios.get(
                '/api/analytics/top-items-by-sales',
            )
            setTotalRevenue(totalRevenueResponse.data.total_revenue)
            setTotalFollowersGained(
                totalFollowersGainedResponse.data.total_followers_gained,
            )
            const items = topItemsBySalesResponse.data.top_items_by_sales.join(
                ', ',
            )
            setTopItemsBySales(items)
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

    const handleChecked = async event => {
        try {
            let isRead = !event.is_read
            await axios.put(`/api/events/${event.id}`, { is_read: isRead })
            alert(`Marked event as ${isRead ? 'read' : 'unread'}`)
        } catch (error) {
            setError(error)
        } finally {
            const eventIndex = events.findIndex(e => e.id === event.id)
            events[eventIndex].is_read = !events[eventIndex].is_read
            setEvents(events)
        }
    }

    useEffect(() => {
        if (events.length === 0 && !endOfResults) {
            fetchEvents()
            fetchAnalytics()
        } else {
            window.scrollTo(0, pageHeight)
            window.addEventListener('scroll', handleScroll)

            return () => window.removeEventListener('scroll', handleScroll)
        }
    }, [events])

    if (isLoading) return <div>'Loading...'</div>
    if (error) return <div>'An error has occurred: {error.message}'</div>

    return (
        <AppLayout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Stream Events
                </h2>
            }>
            <div className="max-w-8xl mx-auto flex items-center justify-between">
                <div className="mx-auto mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
                    Total Revenue in the Last 30 Days:{' '}
                    {totalRevenue ? totalRevenue : 0} USD
                </div>
                <div className="mx-auto mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
                    Total Followers Gained in the Last 30 Days:{' '}
                    {totalFollowersGained ? totalFollowersGained : 0}
                </div>
                <div className="mx-auto mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
                    Top 3 Items by Sales in the Last 30 Days:{' '}
                    {topItemsBySales ? topItemsBySales : 'None'}
                </div>
            </div>
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
                                <input
                                    type="checkbox"
                                    defaultChecked={event.is_read}
                                    onChange={() => handleChecked(event)}
                                />
                            </div>
                        </div>
                    </div>
                ))}
            </div>
            {endOfResults ? (
                <div className="py-6 text-center">No events to fetch!</div>
            ) : (
                <></>
            )}
        </AppLayout>
    )
}

export default Dashboard
