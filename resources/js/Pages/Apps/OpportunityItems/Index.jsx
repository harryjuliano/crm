import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { opportunityItems } = usePage().props

  return (
    <>
      <Head title='Opportunity Item' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.opportunity-items.create')} label='Tambah Opportunity Item' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.opportunity-items.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Opportunity Item'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Opportunity ID</Table.Th><Table.Th>Item Type</Table.Th><Table.Th>Deskripsi</Table.Th><Table.Th>Qty</Table.Th><Table.Th>Harga</Table.Th><Table.Th>Disc %</Table.Th><Table.Th>Subtotal</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {opportunityItems.data.length ? opportunityItems.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (opportunityItems.current_page - 1) * opportunityItems.per_page}</Table.Td>
                <Table.Td>{item.opportunity_id}</Table.Td><Table.Td>{item.item_type}</Table.Td><Table.Td>{item.description}</Table.Td><Table.Td>{item.qty}</Table.Td><Table.Td>{item.estimated_price}</Table.Td><Table.Td>{item.estimated_discount_percent}</Table.Td><Table.Td>{item.subtotal}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.opportunity-items.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.opportunity-items.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={9} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={opportunityItems.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
